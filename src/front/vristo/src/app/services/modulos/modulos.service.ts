import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable, map } from 'rxjs';
import { ApisConfiguration } from 'src/app/app.apisconfig';
import { IMenu } from '../menus/IMenu';
import { IModulo } from './IModulo';

@Injectable({
  providedIn: 'root'
})
export class ModulosService {

  constructor(private httpClient:HttpClient) { }

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

  private getHeaders(): HttpHeaders{
    return new HttpHeaders().set('Authorization',"Basic "+sessionStorage.getItem('uto'));
  }

  private requestOptions(){
    return {
      headers:this.getHeaders()
    }
  }

}
