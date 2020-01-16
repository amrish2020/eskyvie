export default class Gate{
    constructor(user){
        this.user=user;
    }

    isClientAdmin(){
        return this.user.role === 1;
    }
    isAdmin(){
        return this.user.role === 2;
    }
    isSalesMgr(){
        return this.user.role === 3;
    }
    isSalesExec(){
        return this.user.role === 4;
    }
    isMarMgr(){
        return this.user.role === 5;
    }
    isMarExec(){
        return this.user.role === 6;
    }
    isCustomer(){
        return this.user.role === 7;
    }
    isMarExecOrMarMgr(){
        return this.user.role === 5 || this.user.role === 6;
    }
    isSaleExecOrSaleMgr(){
        console.log(' role : '+this.user.role);
        return this.user.role === 3 || this.user.role === 4;
    }
}
