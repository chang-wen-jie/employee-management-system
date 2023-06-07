<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Event;

class DashboardController extends Controller
{
    public function index()
    {
        $active_employees = Employee::where('account_status', 'active')->paginate(10);

        return view('dashboard', [
            'active_employees' => $active_employees,
        ]);
    }

    /**
     * Personeel's logboek weergeven.
     */
    public function showLogs(int $id) {
        $employee = Employee::findOrFail($id);

        return view('admin.logs', ['employee' => $employee]);
    }

    /**
     * Ziekgemelde personeel beter melden.
     */
    public function reportRecovery(int $id) {
        $employee_medical_leave = Event::where('employee_id', $id)->whereDate('start', now())->where('called_in_sick', true);
        $employee_medical_leave->update(['called_in_sick' => false]);

        return redirect()->back();
    }
}
