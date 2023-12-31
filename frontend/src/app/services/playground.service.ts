import { HttpClient, HttpHeaders, HttpParams } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { environment } from 'src/environments/environment';
import { Playground } from '../interfaces/playground';

@Injectable()
export class PlaygroundService {
  // const part from api
  private apiUrl: string = environment.apiUrl

  constructor(private http: HttpClient) { }

  listAll(): Observable<any> {
    return this.http.get(`${this.apiUrl}/playground/search?item=50`)
  }

  getById(id: any): Observable <Playground> {
    return this.http.get<Playground>(`${this.apiUrl}/playground/${id}`)
  }


  ownerField(id: any , token:any): Observable<any> {
    const headers = new HttpHeaders({'Authorization' : `Bearer ${token}`})
    return this.http.get(`${this.apiUrl}/playground/owner/${id}` , {headers} )
  }


  //playground part
  create(formData: any , token:any): Observable<any> {
    const headers = new HttpHeaders({'Authorization' : `Bearer ${token}`})
    return this.http.post(`${this.apiUrl}/playground`, formData , {headers} )
  }

  update(id:number , formData:any ,token:any): Observable<any>{
    const headers = new HttpHeaders({'Authorization' : `Bearer ${token}`})
    return this.http.post(`${this.apiUrl}/playground/${id}` , formData , { headers } )
  }

  delete(id: any , token:any): Observable<any> {
    const headers = new HttpHeaders({'Authorization' : `Bearer ${token}`})
    return this.http.delete(`${this.apiUrl}/playground/${id}` ,{ headers } )
  }


  //top rated playground
  getTopRatedPlaygrounds(): Observable<any> {
    return this.http.get<any[]>(`${this.apiUrl}/playgrounds/top-rated`);
  }


  //pending playgrounds
  listPending(token: string): Observable<any> {
    const headers = new HttpHeaders({
      'Authorization' : `Bearer ${token}`
    });

    return this.http.get(`${this.apiUrl}/playground/pending`, { headers });
  }


  //playground status part
  updateStatusAccept(id: number, status: string, token: string) {
    const headers = new HttpHeaders({
      'Authorization' : `Bearer ${token}`
  })
    return this.http.put(`${this.apiUrl}/playground/changeStatus/${id}`,{status}, { headers });
  }

  updateStatusRejected(id: number, status: string, token: string): Observable<any> {
    const headers = new HttpHeaders({
      'Authorization': `Bearer ${token}`
    });
    return this.http.put(`${this.apiUrl}/playground/rejected/${id}`, {status}, {headers});
  }



  //owners part
  displayOwners(token:any): Observable<any> {
    const headers = new HttpHeaders({'Authorization' : `Bearer ${token}`})
    return this.http.get(`${this.apiUrl}/owner` , {headers} )
  }

  deleteOwners(id: any , token:any): Observable<any> {
    const headers = new HttpHeaders({'Authorization' : `Bearer ${token}`})
    return this.http.delete(`${this.apiUrl}/admin/${id}` , {headers} )
  }
  

  //users part
  displayUsers(token:any): Observable<any> {
    const headers = new HttpHeaders({'Authorization' : `Bearer ${token}`})
    return this.http.get(`${this.apiUrl}/user` , {headers} )
  }

  deleteUsers(id: any , token:any): Observable<any> {
    const headers = new HttpHeaders({'Authorization' : `Bearer ${token}`})
    return this.http.delete(`${this.apiUrl}/user/${id}` , {headers} )
  }
}
