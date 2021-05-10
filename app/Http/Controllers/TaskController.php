<?php

namespace App\Http\Controllers;

use App\Models\Prerequisites;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getTasks(int $refresh = 0): iterable
    {
        if ($refresh == 0){
            return Cache::get('getTaskList', function () {
                return Task::with('getPrerequisites')->get();
            });
        }else{
            $taskList = Task::with('getPrerequisites')->get();
            Cache::put('getTaskList', $taskList);
            return $taskList;
        }
    }

    public function getData(Request $request){

        if ($request->status == '*'){
            $data = $this->getTasks();
        }else{
            $orderBy = $request->status == 0 ? 'ASC' : 'DESC';

            $data = Task::with('getPrerequisites')->orderBy('status',$orderBy)->get();
        }
        return response()->Json($data,200);
    }

    public function getTask(Request $request){

        try {
            $data = Task::with('getPrerequisites')->where('_id',$request->id)->first();
            return response()->Json($data,200);
        }catch (\Exception $e){
            return response()->Json($e->getMessage(),500);
        }
    }
    public function index()
    {
        $data = $this->getTasks();

        return response()->Json($data,200);
    }

    public function finishTask(Request $request){

        try {

            $dataControl = Task::find($request->id)->count();
            if ($dataControl > 0){

           $control = Prerequisites::with('getTask')->where('owner_task',$request->id)->get();

                foreach ($control as $value){

                   if ($value->getTask->status == 0){
                       $response = ['task_count' => $control, 'message' => 'There are unfinished missions','operation' => 0];
                       return response()->Json($response,200);
                   }
               }

               $data = Task::find($request->id);
               $data->status = 1;
               $data->save();


               $taskList = $this->getTasks(1);
               $response = ['message' => 'Congratulations Task completed','operation' => 1,'taskList' => $taskList];
               return response()->Json($response,201);

            }
        }catch (\Exception $e){
            return response()->Json($e->getMessage(),500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
        $data = new Task();
        $data->title = $request->title;
        $data->type = $request->type;
        $request->type == 'invoice_ops' ? $data->amount = $request->amount : '';
        $request->type == 'custom_ops' ? $data->country = $request->country : '';
        $data->status = 0;
        $data->save();

        foreach ($request->prerequisites as $value){
            $prerequisites = new Prerequisites();
            $prerequisites->owner_task = $data->_id;
            $prerequisites->task_id = $value['_id'];
            $prerequisites->task_name = $value['title'];
            $prerequisites->save();
        }

        $taskList = $this->getTasks(1);
        $response = ['status' => 'Success', 'taskList' => $taskList];
        return response()->Json($response,201);
        }
        catch (\Exception $e) {
            return response()->Json($e->getMessage(),500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
       Task::where('_id',$request->id)->delete();
       Prerequisites::where('owner_task',$request->id)->orWhere('task_id',$request->id)->delete();
       return response()->json($this->getTasks(1),200);

    }

}
