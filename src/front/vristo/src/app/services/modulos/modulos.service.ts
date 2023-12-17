import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable, map } from 'rxjs';
import { ApisConfiguration } from 'src/app/app.apisconfig';
import { IMenu } from '../menus/IMenu';
import { IModulo } from './IModulo';
import { IRolModulo } from './IRolModulo';

@Injectable({
  providedIn: 'root'
})
export class ModulosService {

  constructor(private httpClient:HttpClient) { }

  getModulos():Observable<any>{
    return this.httpClient.get(ApisConfiguration.apiSystem+"modulos",{headers:this.getHeaders()});
  }

  getModulosPorRol(moduloPid:string):Observable<any>{
    return this.httpClient.get(ApisConfiguration.apiSystem+"modulos/rol/"+moduloPid,{
      headers:this.getHeaders()
    });
  }

  getModulosMenuUsuario():Observable<any>{
    return this.httpClient.get<any>(ApisConfiguration.apiSystem+"modulo/menus/usuario",{
      headers:this.getHeaders()
    });
  }

  getRolModulos(rolPid:string):Observable<any>{
    return this.httpClient.get(ApisConfiguration.apiSystem+"modulos/rol/"+rolPid+"/relacion",{headers:this.getHeaders()});
  }

  addRolModulo(rolmodulo:IRolModulo):Observable<any>{
    return this.httpClient.post(ApisConfiguration.apiSystem+"modulos/rol",JSON.stringify(rolmodulo),{headers:this.getHeaders()});
  }

  deleteRolModulo(pid:string):Observable<any>{
    return this.httpClient.delete(ApisConfiguration.apiSystem+"modulos/rol/"+pid,{headers:this.getHeaders()});
  }

  private getHeaders(): HttpHeaders{
    return new HttpHeaders().set('Authorization',"Basic "+sessionStorage.getItem('uto'));
  }

  private requestOptions(){
    return {
      headers:this.getHeaders()
    }
  }

}
