//1. For import syntax
export  default class Form {

	constructor(data){

		this.status = '' ;
		this.data = data ;

		
		
		this.error = {} ;
		this.hide = false ;

		for(let val in this.data){
			this[val] = data[val] ;
		}
	}

	send(type , url , data){

		return new Promise((resolve , reject) =>{

			axios[type](url , data).then(res =>{
				
				resolve(res);
				this.error  = '' ;
			}).catch(err =>{

			this.error = err.response.data.errors ;
			this.errors(this.error) ;
				reject(err)
			})
		});

	}

		update(type , url , data){

		return new Promise((resolve , reject) =>{

			axios[type](url , data).then(res =>{
				
				resolve(res);
			}).catch(err =>{

			this.error = err.response.data.errors ;
			this.errors(this.error) ;
				reject(err)
			})
		});

	}

	delete(id){

		return new Promise((resolve , reject) =>{


			 axios.delete('api/user/'+id).then(res =>{
				resolve(res) 		
			 }).catch(err =>{
			 	reject(err)
			 })
		})
		
	}

	fill(data){
		for(let val in data){
			this[val] = data[val] ;
		}
	}


	clearing(){

		for(let val in this.data){
	 		
	 		this[val] = '' ; 
	 	}

	}

	 errors(data){
	 	for(let val in data){
	 		
	 		this.error[val] = data[val][0] ; 
	 	}
	 }


	clear(data){

		delete this.error[data];

		

		if(Object.keys(this.error).length > 0){
			this.hide = true ;
		}else{
			this.hide = false ;
		}
	}

	
}
