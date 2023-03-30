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
  

};

export { service };