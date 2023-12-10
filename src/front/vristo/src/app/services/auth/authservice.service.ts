import { Injectable } from '@angular/core';
import { AuthRequest } from './AuthRequest';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class Authservice {

  constructor(private httpClient: HttpClient) {    
  }
  
  authUser(userCredentials:AuthRequest):Observable<any>{
    return this.httpClient.post("http://localhost/apiusuariosroles/public/api/auth",JSON.stringify(userCredentials));
  }

}
