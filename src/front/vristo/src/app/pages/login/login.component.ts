import { Component } from '@angular/core';
import { FormBuilder,Validator, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { Authservice } from 'src/app/services/auth/authservice.service';
import { AuthRequest } from 'src/app/services/auth/AuthRequest';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent {

  
  loginForm=this.formBuilder.group({
    user:["",Validators.required],
    password:["",Validators.required]
  });

  showErrorMessage:boolean=false;

  constructor(private formBuilder:FormBuilder, private routes:Router, private authUserService:Authservice) {}

ngOnInit(): void {
  
  if((sessionStorage.getItem('upid')!=null )
  && sessionStorage.getItem('rolPid')!=null || sessionStorage.getItem('uto')!=null) 
  this.routes.navigateByUrl('/admin');
  
}

  authUser(){
    this.showErrorMessage=false;
    if(!this.loginForm.valid){
      this.showErrorMessage=true;
      return;
    } 
    
    //todo call service auth user

    this.authUserService.authUser(this.loginForm.value as AuthRequest).subscribe({
      next:(response)=>{
        
        sessionStorage.setItem('upid',response.data.pid);
        sessionStorage.setItem('rolPid',response.data.rolPid);
        sessionStorage.setItem('uto',response.data.token);

        this.routes.navigateByUrl('/admin');
        this.loginForm.reset();
      },
      error:(error)=>{
        this.showErrorMessage=true;
        return;
      },
      complete:()=>{
        
      }
    });
    
  }
  

}
