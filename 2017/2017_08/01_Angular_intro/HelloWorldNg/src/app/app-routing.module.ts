import {RouterModule, Routes} from '@angular/router';
import {NgModule} from '@angular/core';
import {OneComponent} from './one/one.component';
import {TwoComponent} from './two/two.component';
import {PageNotFoundComponent} from './page-not-found/page-not-found.component';

const routes: Routes = [
  { path: 'one', component: OneComponent},
  { path: 'two', component: TwoComponent},
  { path: '',   redirectTo: 'one', pathMatch: 'full' },
  { path: '**', component: PageNotFoundComponent },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule],
  providers: []
})
export class AppRoutingModule { }

