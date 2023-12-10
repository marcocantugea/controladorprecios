import { Component } from '@angular/core';
import { Router } from '@angular/router';

@Component({
  selector: 'app-auth-signout',
  templateUrl: './auth-signout.component.html',
  styleUrls: ['./auth-signout.component.css']
})
export class AuthSignoutComponent {

  constructor(private router:Router) {
    
  }

  ngOnInit(): void {
    
    //todo remove token from session
    this.router.navigateByUrl('/login');
  }

}
