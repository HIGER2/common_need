import { useFetch } from "./useFech";
import { ref } from "vue"

export  const useUser = () => {


    const AddUser = async (newUser:{name:string, last_name:string, email:string}) => {
        return  await useFetch('/api/admin/users/create', 'POST', newUser);
    };
    
    return {
        AddUser
    };
}