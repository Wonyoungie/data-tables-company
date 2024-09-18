<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
// use Session;

class AuthController extends Controller
{
    function postSignUp(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6',
            'confirm_password' => 'required|min:6|same:password'
        ]);

        $passwordCrypt = bcrypt($validated['password']);

        $createMember = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $passwordCrypt,
            'access_group_id' => 2,
            'created_id' => 0,
            'updated_id' => 0,
            'status' => 1,
            'type' => 'member'
        ]);

        // generate token untuk autentikasi user
        $response = $this->generateToken($validated['email'], $validated['name']);

        // if ($createMember && $response->successful()) {
        if ($createMember) {
            return redirect()->route('login', ['direct' => 1]);
        } else {
            return redirect()->back();
        }
    }
    function postSignUpRedirect(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6',
            'confirm_password' => 'required|min:6|same:password'
        ]);

        $passwordCrypt = bcrypt($validated['password']);

        $createMember = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $passwordCrypt,
            'access_group_id' => 2,
            'created_id' => 0,
            'updated_id' => 0,
            'status' => 1,
            'type' => 'member'
        ]);

        // generate token untuk autentikasi user
        $response = $this->generateToken($validated['email'], $validated['name']);
        $redirect = request()->input('redirect', route('getHomepage')); // Ambil nilai redirect atau default ke homepage

        // if ($createMember && $response->successful()) {
        if ($createMember) {
            $this->postSignInRedirect($request);
            return redirect()->route($redirect);
        } else {
            return redirect()->back();
        }
    }
    function postSignUpRedirectRoute(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6',
            'confirm_password' => 'required|min:6|same:password'
        ]);

        $passwordCrypt = bcrypt($validated['password']);

        $createMember = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $passwordCrypt,
            'access_group_id' => 2,
            'created_id' => 0,
            'updated_id' => 0,
            'status' => 1,
            'type' => 'member'
        ]);

        // generate token untuk autentikasi user
        $response = $this->generateToken($validated['email'], $validated['name']);
        $redirect = request()->input('redirect', route('getHomepage')); // Ambil nilai redirect atau default ke homepage

        if ($createMember && $response->successful()) {
            if ($createMember) {
                $this->postSignInRedirectRoute($request);
                return redirect()->to($redirect);
            } else {
                return redirect()->back();
            }
        }
    }

    function postSignUpRedirectNoPassword(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
        ]);

        $passwordCrypt = bcrypt('maxians123');

        $createMember = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $passwordCrypt,
            'access_group_id' => 2,
            'created_id' => 0,
            'updated_id' => 0,
            'status' => 1,
            'type' => 'member'
        ]);

        // generate token untuk autentikasi user
        $response = $this->generateToken($validated['email'], $validated['name']);
        $redirect = request()->input('redirect', route('getHomepage')); // Ambil nilai redirect atau default ke homepage

        if ($createMember && $response->successful()) {
            if ($createMember) {
                $this->postSignInRedirectNoPassword($validated['email'], $redirect);
                return redirect()->to($redirect);
            } else {
                return redirect()->back();
            }
        }
    }

    // Untuk memproses form pendaftaran bootcamp dan produk lainnya
    public function postSignIn(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6'
        ]);

        $signInFailed = true;
        $IdNotActive = true;
        $data = ['id' => $request->course_id];

        $this->generateToken($validated['email'], 'dummy');

        // Untuk menghindari if else yang terlalu panjang/hell
        if (!auth()->attempt($request->only(['email', 'password']) + ['status' => 1])) {
            if ($user = User::where('email', $request->email)->first()) {
                if ($user->status == 0) {
                    return back()->with('IdNotActive', $IdNotActive);
                }
            }
            return back()->with('signInFailed', $signInFailed);
        }

        try {
            $user = auth()->user();

            if ($user) {
                $oldLastLoggedIn = Carbon::parse($user->last_loggedin);
                $newLastLoggedIn = Carbon::now();

                // Compare the difference in days
                $dayDifference = $newLastLoggedIn->diffInDays($oldLastLoggedIn);

                // Update 'strict' column based on the difference
                if ($dayDifference == 1 || $user->strict == 0) {
                    auth()->user()->update(['strict' => $user->strict + 1]);
                } elseif ($dayDifference > 1) {
                    auth()->user()->update(['strict' => 0]);
                }
            }
            // Update 'last_loggedin' column
            auth()->user()->update(['last_loggedin' => $newLastLoggedIn]);
        } catch (\Exception $exception) {
            return back()->with('signInFailed', $signInFailed);
        }

        // Direct -> 1: ke LMS, 2: kembali ke Course Detail, 3: ke form pembayaran
        if ($request->direct == 1) {
            $user = auth()->user();
            if ($user->address != null && $user->phone != null) {
                // Pengguna mencoba mengakses getCourse langsung
                return redirect()->route('lms.dashboard');
            } else {

                return redirect()->route('lms.inputform');
            }
        } else if ($request->direct == 2) {
            // ini berarti dari course detail teken use voucher tpi blm login, jadi dikembalikan ke halaman course detail
            return redirect()->route('products.getDetailCareerBootcamp', $data);
        } else if ($request->direct == 3) {
            if ((int) $request->is_submit === 0) {
                $request['direct'] = "1";
            }
            // Pengguna sudah login dan akan diarahkan ke form-daftar
            return redirect()->route('form-registration', $request->only(['course_id', 'payment_link', 'direct', 'is_submit']));
        } else if ($request->direct == 4) {
            //Untuk Prakerja yang sudah ada payment linknya dan langsung diarahkan ke sana
            return redirect($request->payment_link);
        } else if ($request->direct == 5) {
            //Untuk Voucher prakerja dimana user ketika sudah login akan diarahkan ke page detailnya kembali
            return redirect()->route('products.getDetailPrakerja', $data);
        } else if ($request->direct == 6) {
            //Untuk Voucher minibcp dimana user ketika sudah login akan diarahkan ke page detailnya kembali
            return redirect()->route('products.getDetailMiniBootcamp', $data);
        } else {
            return redirect()->route('getHomepage');
        }
    }

    public function postSignInRedirect(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6'
        ]);

        $signInFailed = true;
        $IdNotActive = true;
        $data = ['id' => $request->course_id];

        $this->generateToken($validated['email'], 'dummy');

        // Untuk menghindari if else yang terlalu panjang/hell
        if (!auth()->attempt($request->only(['email', 'password']) + ['status' => 1])) {
            if ($user = User::where('email', $request->email)->first()) {
                if ($user->status == 0) {
                    return back()->with('IdNotActive', $IdNotActive);
                }
            }
            return back()->with('signInFailed', $signInFailed);
        }

        try {
            $user = auth()->user();

            if ($user) {
                $oldLastLoggedIn = Carbon::parse($user->last_loggedin);
                $newLastLoggedIn = Carbon::now();

                // Compare the difference in days
                $dayDifference = $newLastLoggedIn->diffInDays($oldLastLoggedIn);

                // Update 'strict' column based on the difference
                if ($dayDifference == 1 || $user->strict == 0) {
                    auth()->user()->update(['strict' => $user->strict + 1]);
                } elseif ($dayDifference > 1) {
                    auth()->user()->update(['strict' => 0]);
                }
            }
            // Update 'last_loggedin' column
            auth()->user()->update(['last_loggedin' => $newLastLoggedIn]);
        } catch (\Exception $exception) {
            return back()->with('signInFailed', $signInFailed);
        }

        $redirect = $request->input('redirect', route('getHomepage'));
        return redirect()->route($redirect);
    }
    public function postSignInRedirectRoute(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6'
        ]);

        $signInFailed = true;
        $IdNotActive = true;
        $data = ['id' => $request->course_id];

        $this->generateToken($validated['email'], 'dummy');

        // Untuk menghindari if else yang terlalu panjang/hell
        if (!auth()->attempt($request->only(['email', 'password']) + ['status' => 1])) {
            if ($user = User::where('email', $request->email)->first()) {
                if ($user->status == 0) {
                    return back()->with('IdNotActive', $IdNotActive);
                }
            }
            return back()->with('signInFailed', $signInFailed);
        }

        try {
            $user = auth()->user();

            if ($user) {
                $oldLastLoggedIn = Carbon::parse($user->last_loggedin);
                $newLastLoggedIn = Carbon::now();

                // Compare the difference in days
                $dayDifference = $newLastLoggedIn->diffInDays($oldLastLoggedIn);

                // Update 'strict' column based on the difference
                if ($dayDifference == 1 || $user->strict == 0) {
                    auth()->user()->update(['strict' => $user->strict + 1]);
                } elseif ($dayDifference > 1) {
                    auth()->user()->update(['strict' => 0]);
                }
            }
            // Update 'last_loggedin' column
            auth()->user()->update(['last_loggedin' => $newLastLoggedIn]);
        } catch (\Exception $exception) {
            return back()->with('signInFailed', $signInFailed);
        }

        $redirect = $request->input('redirect', route('getHomepage'));
        return redirect()->to($redirect);
    }

    public function postSignInRedirectNoPassword($email, $redirect)
    {
        $signInFailed = true;
        $IdNotActive = true;

        $this->generateToken($email, 'dummy');

        // Untuk menghindari if else yang terlalu panjang/hell
        if (!auth()->attempt(['email' => $email, 'password' => 'maxians123', 'status' => 1])) {
            if ($user = User::where('email', $email)->first()) {
                if ($user->status == 0) {
                    return back()->with('IdNotActive', $IdNotActive);
                }
            }
            return back()->with('signInFailed', $signInFailed);
        }

        try {
            $user = auth()->user();

            if ($user) {
                $oldLastLoggedIn = Carbon::parse($user->last_loggedin);
                $newLastLoggedIn = Carbon::now();

                // Compare the difference in days
                $dayDifference = $newLastLoggedIn->diffInDays($oldLastLoggedIn);

                // Update 'strict' column based on the difference
                if ($dayDifference == 1 || $user->strict == 0) {
                    auth()->user()->update(['strict' => $user->strict + 1]);
                } elseif ($dayDifference > 1) {
                    auth()->user()->update(['strict' => 0]);
                }
            }
            // Update 'last_loggedin' column
            auth()->user()->update(['last_loggedin' => $newLastLoggedIn]);
        } catch (\Exception $exception) {
            return back()->with('signInFailed', $signInFailed);
        }

        return redirect()->to($redirect);
    }

    function handlePost($email)
    {
        if (Auth::guard('web')->attempt(['email' => $email, 'password' => 'default'])) {
            echo '<script>window.location.href = "' . route('lms.dashboard') . '";</script>';
        } else {
            echo '<script>window.history.back();</script>';
        }
    }

    function postLogout()
    {
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
            session()->forget('token');

            return redirect()->route('getHomepage');
        }
    }

    function postLogoutRedirect(Request $request)
    {
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
            session()->forget('token');

            $redirect = $request->input('redirect', route('getHomepage'));

            return redirect()->route($redirect);
        }
    }
    function postLogoutRedirectRoute(Request $request)
    {
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
            session()->forget('token');

            $redirect = $request->input('redirect', route('getHomepage'));

            return redirect()->to($redirect);
        }
    }

    function forgotPassword(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $signInFailed = true;
        $IdNotActive = true;
        $user = User::where('email', $request->email)->first();

        if ($user->status == 0) {
            return back()->with('IdNotActive', $IdNotActive);
        } else {
            $user->last_reset_password = date('Y-m-d H:i:s');
            $user->save();
            $user->otp = base64_encode($user->id . "+reset+" . strtotime(date('Y-m-d H:i:s')));
            Mail::send('mail.forgot_mail', ['input' => $user], function ($props) use ($user) {
                $props->subject('Forgot Password');
                $props->to($user['email'], $user['nama']);
                $props->from(env("MAIL_USERNAME"), env("MAIL_FROM_NAME"));
            });
            CourseClassMemberLog::requestChangePassword($user->id);
            Log::info($user->otp);
            return redirect()->route('getResetPassword');
        }
    }

    function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6',
            'confirm_password' => 'required|min:6|same:password',
            'otp' => 'required'
        ]);

        $IdNotActive = true;
        $Expired = true;
        $signInFailed = true;
        $request->otp = base64_decode($request->otp);
        $user = User::where('id', explode('+reset+', $request->otp)[0])->first();

        if ($user->status == 0) {
            return back()->with('IdNotActive', $IdNotActive);
        } else {
            $now = strtotime("-10 minutes");

            if ($now > strtotime($user->last_reset_password)) {
                return redirect()->route('forgot')->with('Expired', $Expired);
            }
            if ($user->email != $request->email)
                return back()->with('signInFailed', $signInFailed);
            else {
                $user->password = bcrypt($request->password);
                $user->save();
                CourseClassMemberLog::changePassword($user->id);
                return redirect()->route('login');
            }
        }
    }

    function generateToken($email, $name)
    {
        $secretKey = '4D6351655468576D5A7134743777217A25432A462D4A614E645267556A586E32';
        $token = sha1($email . '|' . $secretKey);

        $response = Http::post('https://athena.gokampus.com/auth/login-register', [
            'token' => $token,
            'email' => $email,
            'name' => $name,
            'referral' => 'maxy', // maxy-academy (dev), maxy (prod)
        ]);

        if ($response->successful()) {
            if (isset($response->json()['token'])) {
                session()->put('token', $response->json()['token']);
            } else {
                alert()->error('Gagal', $response->json()['message']);
            }
            return $response;
        } else {
            return null;
        }
    }
}
