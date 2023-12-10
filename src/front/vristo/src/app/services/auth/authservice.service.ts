import { Injectable } from '@angular/core';
import { AuthRequest } from './AuthRequest';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { ApisConfiguration } from 'src/app/app.apisconfig';

@Injectable({
  providedIn: 'root'
})
export class Authservice {

  constructor(private httpClient: HttpClient) {    
  }
  
  authUser(userCredentials:AuthRequest):Observable<any>{
    return this.httpClient.post(ApisConfiguration.apiAuth,JSON.stringify(userCredentials));
  }

}
