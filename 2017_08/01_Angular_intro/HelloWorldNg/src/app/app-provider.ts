import {Http, Jsonp} from '@angular/http';
import {OneSvcService} from './service/one-svc.service';

export class AppProvider {

  static getOneSvc( http: Http )
  {
    return new OneSvcService( http );
  }
}
