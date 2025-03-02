import { Component } from '@angular/core';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'pft';
  
  isLogin: boolean = true; // Default to login

  showForm(type: string): void {
    this.isLogin = type === 'login';
  }
}
