import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { ApisConfiguration } from 'src/app/app.apisconfig';
import { IRolUsuario } from './IRolUsuario';
import { IRol } from './IRol';
import { IRolAccion } from '../acciones/IRolAccion';

@Injectable({
  providedIn: 'root'
})
export class RolService {

  constructor(private httpClient:HttpClient) { }

  GetRoles():Observable<any>{
    return this.httpClient.get(ApisConfiguration.apiRoles+"es",{headers:this.getHeaders()});
  }

  GetRolDeUsuario(pid:string):Observable<any>{
    return this.httpClient.get(ApisConfiguration.apiRoles+"/usuario/"+pid+"/relacion",{headers:this.getHeaders()});
  }

  AddRol(rol:IRol){
    return this.httpClient.post(ApisConfiguration.apiRoles,JSON.stringify(rol),{headers:this.getHeaders()});
  }

  AddRolUsuario(rolusuario:IRolUsuario):Observable<any>{
    return this.httpClient.post(ApisConfiguration.apiRoles+"/usuario",JSON.stringify(rolusuario),{headers:this.getHeaders()});
  }

  AddRolAccion(rolAccion:IRolAccion):Observable<any>{
    return this.httpClient.post(ApisConfiguration.apiRoles+"/accion",JSON.stringify(rolAccion),{headers:this.getHeaders()});
  }
  
  DeleteRol(pid:string):Observable<any>{
    return this.httpClient.delete(ApisConfiguration.apiRoles+"/"+pid,{headers:this.getHeaders()});
  }

  DeleteAccionFromRol(pid:string):Observable<any>{
    return this.httpClient.delete(ApisConfiguration.apiRoles+"/accion/"+pid,{headers:this.getHeaders()});
  }

  GetAccionesRol(pid:string):Observable<any>{
    return this.httpClient.get(ApisConfiguration.apiRoles+"es/"+pid+"/acciones",{headers:this.getHeaders()});
  }

  private getHeaders(): HttpHeaders{
    return new HttpHeaders().set('Authorization',"Basic "+sessionStorage.getItem('uto')).set('Content-Type', 'application/json; charset=utf-8');
  }

}
