import {service} from "@/services/CrudService";
import router from "@/routes";
const myMiddleware = (to, from, next) => {
    if (to.path === '/login') {
        next();
    }
    service.read('Client').then(res=>{
        if(res.error || res.fail){
           console.clear();
           router.push('/login')
        }
    }).catch(e=>{
        console.log(e, 'autentyfikacja zawiodla')
        console.clear();
        router.push('/login');
    });
   next();
};
export default  myMiddleware;