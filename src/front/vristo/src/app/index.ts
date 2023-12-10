import { Component } from '@angular/core';
import { LoadingModalService } from './components/modal/loading/loading/loading.service';

@Component({
    moduleId: module.id,
    templateUrl: './index.html',
})
export class IndexComponent {

    constructor(private loadingModal:LoadingModalService) {}

    ngOnInit(): void {
        this.showLoading();
        setTimeout(() => {
            this.loadingModal.closeLoading() 
        }, 10000);
    }

    showLoading(){
        this.loadingModal.showLoading();
    }


}
