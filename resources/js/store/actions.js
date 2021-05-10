export const taskListAction = (vuexContext) => {
    axios.get("/api/get-tasks")
        .then(response => {
            vuexContext.commit("setTaskList",response.data);
        })
}

export const addTask = (vuexContext, {data}) => {
    return axios.post("/api/add-task",data).then(response => {
      vuexContext.commit("setTaskList",response.data.taskList);
      return response;
        }).catch(error => {
        return error;
    })
}

export const finishTask = (vuexContext, {data}) => {
    return axios.get("/api/finish-task",{
        params:{
            id:data
        }
    }).then(response => {
        if (response.data.operation == 1){
            vuexContext.commit("setTaskList",response.data.taskList);
        }
        return  response;
    }).catch(error => {
        return error;
    })
}

export const getTask = (vuexContext, {data}) => {
    return axios.get("/api/get-task",{
        params:{
            id:data
        }
    }).then(response => {
        return  response;
    }).catch(error => {
        return error;
    })
}

export const getData = (vuexContext, {data}) => {
    return axios.get("/api/get-data",{
        params:{
            status:data
        }
    }).then(response => {
        vuexContext.commit("setTaskList",response.data);
    }).catch(error => {
        return error;
    })
}

export const deleteData = (vuexContext, {data}) => {
    return axios.get("/api/delete-data",{
        params:{
            id:data
        }
    }).then(response => {
        vuexContext.commit("setTaskList",response.data);
    }).catch(error => {
        return error;
    })
}



