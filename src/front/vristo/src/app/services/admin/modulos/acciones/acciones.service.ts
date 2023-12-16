import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { ApisConfiguration } from 'src/app/app.apisconfig';
import { IRolAccion } from './IRolAccion';

@Injectable({
  providedIn: 'root'
})
export class AccionesService {

  constructor(private httClient:HttpClient) { }

  GetAcciones():Observable<any>{
    return this.httClient.get(ApisConfiguration.apiAcciones+"es",{headers: this.getHeaders()});
  }
  
  private getHeaders(): HttpHeaders{
    return new HttpHeaders().set('Authorization',"Basic "+sessionStorage.getItem('uto')).set('Content-Type', 'application/json; charset=utf-8');
  }
}
