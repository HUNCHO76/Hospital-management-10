<x-app-layout>

          <div class="row" style="position: relative; top:5%;">
            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Create User</h4>
                  <p class="card-description"> User </p>
                    <form method="POST" action="{{ route('admin.user.store') }}" class="forms-sample">
                        @csrf
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="exampleInputName1">FirstName</label>
                          <input type="text" name="FirstName" class="form-control" id="exampleInputName1" placeholder="Name">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputName1">MiddleName</label>
                          <input type="text" name="MiddleName" class="form-control" id="exampleInputName1" placeholder="Name">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputName1">LastName</label>
                          <input type="text" name="LastName" class="form-control" id="exampleInputName1" placeholder="Name">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputEmail3">Email address</label>
                          <input type="email" name="email" class="form-control" id="exampleInputEmail3" placeholder="Email">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputPassword4">Password</label>
                          <input type="password" name="password" class="form-control" id="exampleInputPassword4" placeholder="Password">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="exampleSelectGender">Role</label>
                          <select class="form-select" id="exampleSelectGender">
                            <option value="local" >Local</option>
                            <option value="nurse" >Nurse</option>
                            <option value="doctor" >Doctor</option>
                            <option value="admin" >Admin</option>
                            <option value="receptionist" >Receptionist</option>
                            <option value="pharmacist" >Pharmacist</option>
                            <option value="labtechnician" >Lab Technician</option>
                            <option value="accountant" >Accountant</option>
                            <option value="hr" >HR</option>
                            <option value="radiologist" >Radiologist</option>
                            <option value="physiotherapist" >Physiotherapist</option>
                            <option value="dietitian" >Dietitian</option>
                            <option value="technician" >Technician</option>

                          </select>
                        </div>
                        <div class="form-group"></div>
                          <label for="exampleSelectGender">Status</label>
                          <select class="form-select" id="exampleSelectGender">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                          </select>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-gradient-primary me-2">Create</button>
                    <button class="btn btn-light">Cancel</button>
                  </form>
                </div>
              </div>
            </div>

        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2023 <a href="https://www.bootstrapdash.com/" target="_blank">BootstrapDash</a>. All rights reserved.</span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="mdi mdi-heart text-danger"></i></span>
          </div>
        </footer>
        <!-- partial -->
      </div>
</x-app-layout>
