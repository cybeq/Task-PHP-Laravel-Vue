const service = {
    read: async function (model, id) {
        let url = `/api/read/${model}`
        if(id) url = `${url}/${id}`;
        try {
            const response = await fetch(url);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return await response.json();
        } catch (error) {
            console.error(error);
            return {"error":error};
        }
    },
    delete: async function(model, id){
        let url = `/api/delete/${model}/${id}`
        try {
            const response = await fetch(url, {method:'DELETE'});
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return await response.json();
        } catch (error) {
            console.error(error);
            return {"error":error};
        }
    },
    edit: async function(model, id, body){
        console.log(model, id, body)
        let url = `/api/update/${model}/${id}`
        try {
            const response = await fetch(url,{
                method:'PUT',
                headers: {
                    'Content-Type': 'application/json'
                },
                body:JSON.stringify(body)
            });
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return await response.json();
        } catch (error) {
            console.error(error);
            return {"error":error};
        }
    },
    create: async function(model, body){
        console.log(model, body)
        let url = `/api/create/${model}/`
        try {
            const response = await fetch(url,{
                method:'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body:JSON.stringify(body)
            });
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return await response.json();
        } catch (error) {
            console.error(error);
            return {"error":error};
        }
    }
};

export { service };