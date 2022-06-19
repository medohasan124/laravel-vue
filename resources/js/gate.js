export default class gate{

	constructor(user){
		this.user = user ;
	} ;

	isAdmin(){
		return this.user.type == 1 ;
	}

	isUser(){
		return this.user.type == 2 ;
	}


} 