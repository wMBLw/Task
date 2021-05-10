import TaskList from './components/TaskList'
import AddTask from './components/AddTask'
import EditTask from './components/EditTask'
export const routes = [
    {
        name: 'taskList',
        path: '/',
        component: TaskList
    },
    {
        name: 'addTask',
        path: '/add-task',
        component: AddTask
    },
    {
        name: 'editTask',
        path: '/edit-task/:id',
        component: EditTask
    },

];
