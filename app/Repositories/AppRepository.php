<?php

namespace App\Repositories;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Request;
class AppRepository
{
    /**
     * Eloquent model instance.
     */
    protected $model;
    /**
     * load default class dependencies.
     *
     * @param Model $model Illuminate\Database\Eloquent\Model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
    /**
     * get all the items collection from database table using model.
     *
     * @return Collection of items.
     */
    public function get()
    {
        return $this->model->get();
    }

    /**
     * create new record in database.
     *
     * @param Request $request Illuminate\Http\Request
     * @return saved model object with data.
     */
    public function store(Request $request)
    {

        $item = $this->model->create($request->all());
        return $item;


    }
    /**
     * update existing item.
     *
     * @param  Integer $id integer item primary key.
     * @param Request $request Illuminate\Http\Request
     * @return send updated item object.
     */
    public function update($id, Request $request)
    {

        $item = $this->model->findOrFail($id);
        $item->update($request->all());

        return $item;
    }
    /**
     * get requested item and send back.
     *
     * @param  Integer $id: integer primary key value.
     * @return send requested item data.
     */
    public function show($id)
    {
        return $this->model->findOrFail($id);
    }
    /**
     * Delete item by primary key id.
     *
     * @param  Integer $id integer of primary key id.
     * @return boolean
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function restore($id)
    {
       return $this->model->withTrashed()->findorfail($id)->restore();
     
    }
    /**
     * get collection of items in paginate format.
     *
     * @return Collection of items.
     */
    public function paginate(Request $request)
    {

        return $this->model->paginate($request->input('limit', 10));
    }

    /**
     * set data for saving
     *
     * @param  Request $request Illuminate\Http\Request
     * @return array of data.
     */
    // protected function setDataPayload(Request $request)
    // {
    //     return $request->all();
    // }


}
