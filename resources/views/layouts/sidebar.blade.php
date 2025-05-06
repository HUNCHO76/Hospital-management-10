
<nav class="sidebar sidebar-offcanvas fixed" id="sidebar">
    <ul class="nav">
      <li class="nav-item nav-profile">
        <a href="#" class="nav-link">
          <div class="nav-profile-image">
            <img src="{{ asset('build/assets/images/faces/face1.jpg') }}" alt="profile" />
            <span class="login-status online"></span>
            <!--change to offline or busy as needed-->
          </div>
          <div class="nav-profile-text d-flex flex-column">
            <span class="font-weight-bold mb-2">David Grey. H</span>
            <span class="text-secondary text-small">Project Manager</span>
          </div>
          <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
        </a>
      </li>
      <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#dashboard" aria-expanded="false" aria-controls="dashboard">
              <span class="menu-title">Dashboard</span>
              <i class="mdi mdi-view-dashboard menu-icon"></i>
          </a>
          <div class="collapse" id="dashboard">
              <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                      <a class="nav-link" href="{{ route('dashboard') }}">Overview</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="pages/dashboard/stats.html">Stats</a>
                  </li>
              </ul>
          </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
          <span class="menu-title">Admin</span>
          <i class="menu-arrow"></i>
               <i class="mdi mdi-account-circle menu-icon"></i>
        </a>
        <div class="collapse" id="ui-basic">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="pages/ui-features/buttons.html">Buttons</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pages/ui-features/dropdowns.html">Dropdowns</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pages/ui-features/typography.html">Typography</a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
            <span class="menu-title">Reception</span>
            <i class="mdi mdi-deskphone menu-icon"></i>
          </a>
          <div class="collapse" id="icons">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('patient.create') }}">Patients Form</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('patient.index') }}">Patients Table</a>
                </li>
            </ul>
          </div>
        </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#forms" aria-expanded="false" aria-controls="forms">
          <span class="menu-title">Cashier</span>
          <i class="mdi mdi-format-list-bulleted menu-icon"></i>
        </a>
        <div class="collapse" id="forms">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="pages/forms/basic_elements.html">Form Elements</a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#manage-users" aria-expanded="false" aria-controls="manage-users">
              <span class="menu-title">Manage Users</span>
              <i class="mdi mdi-account-group menu-icon"></i>
          </a>
          <div class="collapse" id="manage-users">
              <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                      <a class="nav-link" href="{{ route('admin.user.create') }}">Create User</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="{{ route('admin.index.index') }}">User</a>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link" href="pages/users/staff.html">Staff</a>
                  </li>
              </ul>
          </div>
      </li>
      <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#appointments" aria-expanded="false" aria-controls="appointments">
              <span class="menu-title">Appointments</span>
              <i class="mdi mdi-calendar-check menu-icon"></i>
          </a>
          <div class="collapse" id="appointments">
              <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                      <a class="nav-link" href="pages/appointments/view.html">View</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="pages/appointments/approve.html">Approve</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="pages/appointments/cancel.html">Cancel</a>
                  </li>
              </ul>
          </div>
      </li>
      <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#departments" aria-expanded="false" aria-controls="departments">
              <span class="menu-title">Manage Department</span>
              <i class="mdi mdi-hospital-building menu-icon"></i>
          </a>
          <div class="collapse" id="departments">
              <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('department.create') }}">Create Department</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('department.index') }}">Department Table</a>
                    </li>
              </ul>
          </div>
    <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#manage-doctors" aria-expanded="false" aria-controls="manage-doctors">
            <span class="menu-title">Manage Doctors</span>
            <i class="mdi mdi-doctor menu-icon"></i>
        </a>
        <div class="collapse" id="manage-doctors">
            <ul class="nav flex-column sub-menu">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('doctor.create') }}">Create Doctor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('doctor.index') }}">Doctors Table</a>
                </li>
            </ul>
        </div>
    </li>
      <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#rooms-beds" aria-expanded="false" aria-controls="rooms-beds">
              <span class="menu-title">Rooms & Beds</span>
              <i class="mdi mdi-bed menu-icon"></i>
          </a>
          <div class="collapse" id="rooms-beds">
              <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                      <a class="nav-link" href="pages/rooms/manage.html">Manage Room Allocation</a>
                  </li>
              </ul>
          </div>
      </li>
      <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#billing" aria-expanded="false" aria-controls="billing">
              <span class="menu-title">Billing</span>
              <i class="mdi mdi-cash-multiple menu-icon"></i>
          </a>
          <div class="collapse" id="billing">
              <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                      <a class="nav-link" href="pages/billing/manage.html">Manage Invoices</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="pages/billing/payments.html">Payments</a>
                  </li>
              </ul>
          </div>
      </li>
      <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#reports" aria-expanded="false" aria-controls="reports">
              <span class="menu-title">Reports</span>
              <i class="mdi mdi-chart-pie menu-icon"></i>
          </a>
          <div class="collapse" id="reports">
              <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                      <a class="nav-link" href="pages/reports/financial.html">Financial Reports</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="pages/reports/appointments.html">Appointment Reports</a>
                  </li>
              </ul>
          </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#nurse" aria-expanded="false" aria-controls="nurse">
          <span class="menu-title">Nurse</span>
          <i class="mdi mdi-chart-bar menu-icon"></i>
        </a>
        <div class="collapse" id="nurse">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#patient-monitoring" aria-expanded="false" aria-controls="patient-monitoring">
                Patient Monitoring
              </a>
              <div class="collapse" id="patient-monitoring">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="{{ route('patient.index') }}">Patient</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ route('pre_tests.index') }}">Patient PreTest</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ route('doctor_patient.index') }}">Patient Assigned</a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#ward-management" aria-expanded="false" aria-controls="ward-management">
                Ward Management
              </a>
              <div class="collapse" id="ward-management">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="pages/nurse/bed-assignment.html">Bed Assignment</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="pages/nurse/daily-care.html">Daily Care</a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#appointment-assistance" aria-expanded="false" aria-controls="appointment-assistance">
                Appointment Assistance
              </a>
              <div class="collapse" id="appointment-assistance">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="pages/nurse/assist-doctors.html">Assist Doctors</a>
                  </li>
                </ul>
              </div>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#doctor" aria-expanded="false" aria-controls="doctor">
              <span class="menu-title">Doctor</span>
              <i class="mdi mdi-stethoscope menu-icon"></i>
          </a>
          <div class="collapse" id="doctor">
              <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                      <a class="nav-link" href="pages/doctor/my-appointments.html">My Appointments</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="{{ route('assigned_patients') }}">Patient Records</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="pages/doctor/write-prescriptions.html">Write Prescriptions</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="pages/doctor/lab-test-requests.html">Lab Test Requests</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="pages/doctor/medical-reports.html">Medical Reports</a>
                  </li>
              </ul>
          </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#pharmacy" aria-expanded="false" aria-controls="pharmacy">
          <span class="menu-title">Pharmacy</span>
          <i class="mdi mdi-table-large menu-icon"></i>
        </a>
        <div class="collapse" id="pharmacy">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="pages/pharmacy/medicine-inventory.html">Medicine Inventory</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pages/pharmacy/manage-prescriptions.html">Manage Prescriptions</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pages/pharmacy/billing.html">Billing</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pages/pharmacy/profile.html">Profile</a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
          <span class="menu-title">Laboratory</span>
          <i class="menu-arrow"></i>
          <i class="mdi mdi-lock menu-icon"></i>
        </a>
        <div class="collapse" id="auth">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item">
              <a class="nav-link" href="{{ route('lab.index') }}"> Patient </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pages/samples/login.html"> Login </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pages/samples/register.html"> Register </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pages/samples/error-404.html"> 404 </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="pages/samples/error-500.html"> 500 </a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="docs/documentation.html" target="_blank">
          <span class="menu-title">Radiology</span>
          <i class="mdi mdi-file-document-box menu-icon"></i>
        </a>
      </li>
                  <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#settings" aria-expanded="false" aria-controls="settings">
              <span class="menu-title">Settings</span>
              <i class="mdi mdi-settings menu-icon"></i>
          </a>
          <div class="collapse" id="settings">
              <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                      <a class="nav-link" href="pages/settings/system.html">System Settings</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="pages/settings/profile.html">Profile Settings</a>
                  </li>
              </ul>
          </div>
      </li>
    </ul>
  </nav>
