@extends('layout.master-mini')
@section('content')

<div class="content-wrapper d-flex align-items-center justify-content-center auth theme-one" style="background-image: url({{ url('assets/images/auth/bg.png') }}); background-size: cover;">
  <div class="row w-100 mt-3">
    <div class="col-lg-4 mx-auto">
      <h2 class="text-center mb-4 login-title">Login</h2>
      <div class="auto-form-wrapper">
        <form action="#">
          <div class="form-group">
            <label class="label">Username</label>
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Username">
              <div class="input-group-append">
                <span class="input-group-text">
                  <i class="mdi mdi-check-circle-outline"></i>
                </span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="label">Password</label>
            <div class="input-group">
              <input type="password" class="form-control" placeholder="*********">
              <div class="input-group-append">
                <span class="input-group-text">
                  <i class="mdi mdi-check-circle-outline"></i>
                </span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <button class="btn btn-primary submit-btn btn-block mt-5">Login</button>
          </div>
          <div class="form-group d-flex justify-content-between">
            <div class="text-block text-center">
              <span class="text-small font-weight-semibold">Don't have account?</span>
              <a href="{{ route('register.index') }}" class="text-black text-small">Create new account</a>
            </div>
          </form>
        </div>
        <ul class="auth-footer">
          <li>
            <a href="#">Conditions</a>
          </li>
          <li>
            <a href="#">Help</a>
          </li>
          <li>
            <a href="#">Terms</a>
          </li>
        </ul>
        <p class="footer-text text-center">copyright © 2023 ITD All rights reserved.</p>
      </div>
    </div>
  </div>
  
  @endsection