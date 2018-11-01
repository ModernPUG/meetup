import { Component } from '@angular/core';
declare var jQuery: any;

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'app works!!!!!';
  strTest: String = 'hihihihihihihihi';
  baz: String = 'zzzzz';

  onClickedOne( bar )
  {
    console.log('one component clicked!!' , bar );
  }

  // onChangeInput( $e ) {
  //   this.baz = $e.currentTarget.value;
  //   console.log('changed');
  // }

  changeBaz()
  {
    this.baz = 'zzzzzz';
  }

}
