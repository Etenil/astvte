<?php
	
namespace modules\redbean
{
	class Formatter implements \RedBean_IModelFormatter
	{
	    public function formatModel($model)
	    {
	        return 'RBModel_' . $model;
	    }
	}
}