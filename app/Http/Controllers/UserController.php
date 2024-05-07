<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Exports\EnrolleesExport;
use App\Models\Branch;
use App\Models\Enrollee;
use App\Models\Organisation;
use App\Models\Sector;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(UsersDataTable $dataTable)
    {
        $roles = Role::all();
        return $dataTable->render("users.index", compact("roles"));
    }

    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required', 'email' => 'required', 'password' => 'required']);
        $data = $request->except('_token', 'role');
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();
        $data['status'] = 'active';
        $user = User::create($data);
        $user->assignRole($request->role);
        return back()->with('success', 'User created');
    }

    public function show($id)
    {
        $user = User::find($id);
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update($id, Request $request)
    {
        $this->validate($request, ['name' => 'required', 'email' => 'required']);
        $data = $request->except('_token', 'role');
        $data['updated_by'] = auth()->id();
        $user = User::where('id', $id)->first();
        $currentRoles = $user->roles;
        foreach ($currentRoles as $currentRole) {
            $user->removeRole($currentRole);
        }
        $user->update($data);
        $user->assignRole($request->role);
        return back()->with('success','User updated');
    }

    public function delete($id)
    {
        $user = User::where('id', $id)->first();
        $currentRoles = $user->roles;
        foreach ($currentRoles as $currentRole) {
            $user->removeRole($currentRole);
        }
        $user->delete();
        return back()->with('success','User deleted!');
    }

    public function reports()
    {
        $branches = Branch::all();
        $sectors = Sector::all();
        $organisations = Organisation::all();
        return view('users.reports', compact('branches', 'sectors', 'organisations'));
    }

    public function exportReports(Request $request)
    {
        $request->validate([
            'branch' => 'nullable|integer',
            'sector' => 'nullable|integer',
            'category' => 'nullable|integer',
            'organisation' => 'nullable|integer',
            'hcp' => 'nullable|integer',
            'date_from' => 'required|date_format:Y-m-d',
            'date_to' => 'required|date_format:Y-m-d',
            'format' => 'required'
        ]);

        $branch = $request->branch;
        $sector = $request->sector;
        $category = $request->category;
        $organisation = $request->organisation;
        $hcp = $request->hcp;
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $date_range = [$date_from, $date_to];

        $query = Enrollee::query();

        // Define columns to select for export
        $columns = [ 'reference', 'branch.name as branch_name', 'sector.name as sector_name', 'category.name as category_name', 'organisation.name as organisation_name', 'hcp.name as hcp_name', 'pf_number', 'first_name', 'middle_name', 'last_name', 'gender', 'date_of_birth', 'email', 'phone_number', 'address', 'nin', 'marital_status', 'picture', 'blood_group.name as blood_group_name', 'illness', 'date_of_first_appointment', 'occupation', 'designation', 'station', 'hmo', 'enrolled_by' ];

        // Apply joins and eager loading for related models
        $query->leftJoin('branches as branch', 'enrollees.branch_id', '=', 'branch.id')
            ->leftJoin('sectors as sector', 'enrollees.sector_id', '=', 'sector.id')
            ->leftJoin('categories as category', 'enrollees.category_id', '=', 'category.id')
            ->leftJoin('organisations as organisation', 'enrollees.organisation_id', '=', 'organisation.id')
            ->leftJoin('hcps as hcp', 'enrollees.hcp_id', '=', 'hcp.id')
            ->leftJoin('blood_groups as blood_group', 'enrollees.blood_group_id', '=', 'blood_group.id');

        // Apply filters based on input parameters
        if (!is_null($branch)) {
            $query->where('enrollees.branch_id', $branch);
        }


        if (!is_null($sector))
        {
            $query->where('enrollees.sector_id', $sector);
        }

        if (!is_null($category))
        {
            $query->where('enrollees.category_id', $category);
        }

        if (!is_null($organisation))
        {
            $query->where('enrollees.organisation_id', $organisation);
        }

        if (!is_null($hcp))
        {
            $query->where('enrollees.hcp_id', $hcp);
        }

        if (!is_null($date_from) && !is_null($date_to))
        {
            $query->whereBetween('enrollees.created_at', $date_range);
        }

        $format = $request->format;
        if ($format == 'excel')
        {
            $headingRow = [ 'reference', 'branch', 'sector', 'category', 'organisation', 'hcp', 'pf_number', 'first_name', 'middle_name', 'last_name', 'gender', 'date_of_birth', 'email', 'phone_number', 'address', 'nin', 'marital_status', 'picture', 'blood_group', 'illness', 'date_of_first_appointment', 'occupation', 'designation', 'station', 'hmo', 'enrolled_by' ];

            $enrollees = $query->select($columns)->get()->toArray();
            $headingRow = [$headingRow];
            return Excel::download(new EnrolleesExport($enrollees, $headingRow), 'enrollees_'.$date_from.'_'.$date_to.'.xlsx');
        }
        else
        {
            $query->select($columns);
            $enrollees = [];
            $chunkSize = 10000; // Adjust chunk size as needed
            $query->chunk($chunkSize, function ($results) use (&$enrollees) {
                foreach ($results as $result) {
                    $enrollees[] = $result;
                }
            });
            //$enrollees = $query->select($columns)->lazy();
            return Pdf::loadView('enrollees.pdf.enrollees_export', ['enrollees' => $enrollees, 'date_range' => $date_range])->setPaper('a2', 'landscape')->download('enrollees_'.$date_from.'_'.$date_to.'.pdf');
        }
    }

    public function login()
    {
        if (Auth::check()) {
            return redirect(route('user.dashboard'));
        }
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('status', 'active')->where(function ($q) use ($request) {
            $q->where('username', $request->username)
            ->orWhere('email', $request->username);
        })->first();
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user, $request->remember);
            return redirect()->intended(route('user.dashboard'));
        }
        return back()->withErrors(['username' => 'Invalid credentials']);
    }

    public function dashboard()
    {
        $data = [
            'total_enrollees' => Enrollee::count(),
            'branches' => Branch::all(),
            'sectors' => Sector::all(),
            'users' => User::count(),
        ];
        return view('users.dashboard', compact('data'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('login'));
    }

    public function forgot()
    {
        return view('auth.forgot');
    }

    public function requestPasswordReset(Request $request)
    {
        $request->validate(['email' => 'required|email']);
 
        $status = Password::sendResetLink(
            $request->only('email')
        );
    
        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);

    }

    public function passwordReset(string $token)
    {
        return view('auth.reset', ['token' => $token]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);
     
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
     
                $user->save();
     
                event(new PasswordReset($user));
            }
        );
     
        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withErrors(['password' => [__($status)]]);
    }
}
