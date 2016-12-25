import { Component } from '@angular/core';

import { Configuration } from '../classes/configuration';

@Component({
    moduleId: module.id,
    selector: 'dashboard',
    templateUrl: 'template.html',
    styleUrls: ['styles.css']
})
export class Dashboard {
    public footerButtons = false;

    constructor(private config: Configuration) {
        this.config.setBodyClass('white-body');
    }

    showFooterBtnClick(): void {
        this.footerButtons = true;
    }

    closeFooterBtnClick(): void {
        this.footerButtons = false;
    }
}