<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\EnrollmentDB\StudEnrolmentHistory;
use App\Models\TicketDB\WifiVoucher;
use App\Models\TicketDB\StudVoucherReg;

class KioskCampusWiFiController extends Controller
{
    public function index()
    {
        [$guard, $studentowner, $studauth, $studentcampus] = $this->kioskContext();

        $term = $this->currentTerm($studentowner);
        $existing = $term ? $this->existingClaim($studentowner, $term) : null;

        return view('pages.campuswifi', compact('studauth', 'term', 'existing'));
    }

    /**
     * Claim a voucher: take the first available (status = 1) code for the
     * student's current term — no random generation — then mark it used (0).
     */
    public function generate(Request $request)
    {
        [$guard, $studentowner, $studauth] = $this->kioskContext();

        if (!$studentowner || !$studauth) {
            return response()->json(['message' => 'Student session not found. Please sign in again.'], 401);
        }

        $term = $this->currentTerm($studentowner);
        if (!$term) {
            return response()->json(['message' => 'No enrollment record found for this student.'], 422);
        }

        try {
            $result = DB::connection('ticketing')->transaction(function () use ($studentowner, $studauth, $term) {
                // Already claimed this term? Hand back the same code, consume nothing.
                $existing = $this->existingClaim($studentowner, $term);
                if ($existing) {
                    return ['voucher_code' => $existing->voucher->voucher_code, 'fresh' => false];
                }

                // First available code for this term, locked so two kiosks can't grab it.
                $voucher = WifiVoucher::where('status', 1)
                    ->where('schlyear', $term['schlyear'])
                    ->where('semester', $term['semester'])
                    ->orderBy('id', 'asc')
                    ->lockForUpdate()
                    ->first();

                if (!$voucher) {
                    return null;
                }

                $voucher->update(['status' => 0]);

                StudVoucherReg::create([
                    'vc_id' => $voucher->id,
                    'stud_id' => $studentowner,
                    'fullname' => trim($studauth->lname . ', ' . $studauth->fname . ' ' . ($studauth->mname ?? '')),
                    'schlyear' => $term['schlyear'],
                    'semester' => $term['semester'],
                ]);

                return ['voucher_code' => $voucher->voucher_code, 'fresh' => true];
            });
        } catch (\Throwable $e) {
            report($e);

            return response()->json(['message' => 'Unable to generate a voucher right now. Please try again.'], 500);
        }

        if (!$result) {
            return response()->json(['message' => 'No voucher codes left for this semester. Please visit the MIS office.'], 422);
        }

        return response()->json($result);
    }

    /**
     * Student's current term = latest enrollment history row.
     */
    protected function currentTerm(?string $studentowner): ?array
    {
        if (!$studentowner) {
            return null;
        }

        $row = StudEnrolmentHistory::where('studentID', $studentowner)
            ->orderByDesc('schlyear')
            ->orderByDesc('semester')
            ->first(['schlyear', 'semester']);

        return $row ? ['schlyear' => $row->schlyear, 'semester' => $row->semester] : null;
    }

    protected function existingClaim(string $studentowner, array $term): ?StudVoucherReg
    {
        return StudVoucherReg::with('voucher')
            ->whereHas('voucher')
            ->where('stud_id', $studentowner)
            ->where('schlyear', $term['schlyear'])
            ->where('semester', $term['semester'])
            ->latest('id')
            ->first();
    }

    /**
     * Live lookup of this term's code for this student (used by View button,
     * so it never relies on stale page data).
     */
    public function myVoucher()
    {
        [$guard, $studentowner] = $this->kioskContext();

        if (!$studentowner) {
            return response()->json(['message' => 'Student session not found. Please sign in again.'], 401);
        }

        $term = $this->currentTerm($studentowner);
        $existing = $term ? $this->existingClaim($studentowner, $term) : null;

        if (!$existing) {
            return response()->json(['message' => 'No voucher claimed for the current semester yet.'], 404);
        }

        return response()->json(['voucher_code' => $existing->voucher->voucher_code]);
    }
}
