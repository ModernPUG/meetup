import { Injectable } from '@angular/core';
import {Http} from '@angular/http';

@Injectable()
export class OneSvcService {

  constructor( private http: Http ) { }

  getInfo() {
    return this.http.get('/api/getInfo');
  }
}
