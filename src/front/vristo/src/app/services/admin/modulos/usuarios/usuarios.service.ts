import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { ApisConfiguration } from 'src/app/app.apisconfig';
import { IUsuario } from './IUsuario';

@Injectable({
  providedIn: 'root'
})
export class UsuariosService {

  constructor(private httpClient:HttpClient) { }

  getUsuariosSistema():Observable<any> {
    return this.httpClient.get(ApisConfiguration.apiUsuarios+"s",{
      headers:this.getHeaders()
    });
  }

  AddUsuario(usuario:IUsuario):Observable<any>{
    return this.httpClient.post(ApisConfiguration.apiUsuarios,JSON.stringify(usuario),{
      headers:this.getHeaders()
    });
  }

  DeleteUsuario(pid:string):Observable<any>{
    return this.httpClient.delete(ApisConfiguration.apiUsuarios+"/"+pid,{
      headers:this.getHeaders()
    });
  }

  ActivarUsuario(pid:string):Observable<any>{
    return this.httpClient.put(ApisConfiguration.apiUsuarios+"/activar/"+pid,"",{headers:this.getHeaders()});
  }

  DesactivarUsuario(pid:string):Observable<any>{
    return this.httpClient.put(ApisConfiguration.apiUsuarios+"/desactivar/"+pid,"",{headers:this.getHeaders()});
  }

  ActualizarPassword(pid:string,password:string):Observable<any>{
    let body=JSON.stringify({password:password})
    return this.httpClient.post(ApisConfiguration.apiUsuarios+"/"+pid+"/password/change",body,{headers:this.getHeaders()});
  }
    
  private getHeaders(): HttpHeaders{
    return new HttpHeaders().set('Authorization',"Basic "+sessionStorage.getItem('uto')).set('Content-Type', 'application/json; charset=utf-8');
  }


}
