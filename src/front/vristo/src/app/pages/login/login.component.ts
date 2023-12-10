import { Component } from '@angular/core';
import { FormBuilder,Validator, Validators } from '@angular/forms';
import { Router } from '@angular/router';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent {

  
  loginForm=this.formBuilder.group({
    username:["",Validators.required],
    password:["",Validators.required]
  });

  showErrorMessage:boolean=false;

  constructor(private formBuilder:FormBuilder, private routes:Router) {
      
  }

  authUser(){
    this.showErrorMessage=false;
    if(!this.loginForm.valid){
      this.showErrorMessage=true;
      return;
    } 
    //todo call service auth user
    this.routes.navigateByUrl('/admin');
    this.loginForm.reset();
  }
  

}
