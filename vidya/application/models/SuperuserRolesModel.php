<?php


class SuperuserRolesModel extends MY_Model
{
    protected $table 	= "superusers_roles";

	public function access()
	{
		return $this->hasMany('SuperuserRolesGiveModel', 'roles_id', 'id');
	}

	
}
