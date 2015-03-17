<?php namespace Ormic\Observers;

class Datalog {

    public function saved(\Ormic\Model\Base $model)
    {

        // Don't try to create a datalog for the datalog model!
        if ($model->getTable() == 'datalog')
        {
            return true;
        }

        //dump($model->getSlug(), $model->getAttributes());
        foreach ($model->getDirty() as $field => $new_value)
        {
            // Save the datalog entry.
            $datalog = new \Ormic\Model\Datalog();
            $datalog->table = $model->getTable();
            $datalog->date_and_time = date('Y-m-d H:i:s');
            $datalog->row = $model->id;
            $datalog->field = $field;
            $datalog->old_value = $model->getOriginal($field);
            $datalog->new_value = $model->getAttributeTitle($field); //$new_value;
            $datalog->user_id = $model->getUser()->id;
            $datalog->save();
        }
        return true;
    }

}
