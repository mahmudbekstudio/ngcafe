import { Component } from '@angular/core';

import { Configuration } from "../classes/configuration";

import '../rxjs-operators';

@Component({
  selector: 'application',
  template: `<system-login></system-login>`,
})
export class AppComponent  {

  constructor(public config: Configuration) {
    //this.config.setBodyClass('testing');
  }

}
