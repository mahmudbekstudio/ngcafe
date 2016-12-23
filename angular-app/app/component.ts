import { Component, OnInit } from '@angular/core';

import { Service } from "../classes/service";
import { Configuration } from '../classes/configuration';

import '../rxjs-operators';

@Component({
  selector: 'application',
  template: `
  <div *ngIf="!config.loading">Wait...</div>
  <login *ngIf="config.loading && !config.auth.login"></login>
  <system-login *ngIf="config.loading && config.auth.login && !config.auth.systemLogin"></system-login>
  <div *ngIf="config.loading && config.auth.login && config.auth.systemLogin">Dashboard</div>
  `,
})
export class AppComponent implements OnInit{

  constructor(private service: Service, private config: Configuration) {
    //this.config.setBodyClass('testing');
  }

  ngOnInit(): void {
    this.service.loadConfig();
  }

}
