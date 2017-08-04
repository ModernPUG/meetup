import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {OneSvcService} from "../service/one-svc.service";

declare var jQuery: any;
@Component({
  selector: 'app-one',
  templateUrl: './one.component.html',
  styleUrls: ['./one.component.css']
})
export class OneComponent implements OnInit {

  @Input('foo') foo: String;
  @Output() oneClickEmitter = new EventEmitter();

  bar: String = 'huuuuuu';
  constructor( private oneSvc: OneSvcService ) { }

  ngOnInit() {
    jQuery('#btnJquery').on('click', function(e) {
      console.log( 'btnJquery Test Clicked!!!!');
    })
  }

  onClickByChildren( e ) {
    this.oneClickEmitter.emit( this.bar );
  }

  onClickService()
  {
    console.log( 'onClickService clicked!!!!');
    // console.log( this.oneSvc.getInfo() );
    this.oneSvc.getInfo().subscribe(data => {
      // Read the result field from the JSON response.
      console.log( 'service subscribe', JSON.parse( data.text() ) , this );
      return data;
    })
  }

}
