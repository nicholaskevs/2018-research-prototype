<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Datas extends CI_Model {

    public function getUsage($id, $date, $hour)
    {
        return $this->db->select('amount')
            ->get_where('node_usages', array('nodeid'=>$id, 'date'=>$date, 'time'=>$hour))
            ->row_array()['amount'];
    }

    public function getUsageTotalByDate($userid, $date)
    {
        return $this->db->select_sum('amount')->from('node_usages')
            ->join('nodes', 'node_usages.nodeid = nodes.id')->join('users', 'nodes.userid = users.id')
            ->where('users.id', $userid)->where('date', $date)
            ->get()->row_array()['amount'];
    }

    public function getUsageTotalByHour($userid, $date, $hour)
    {
        return $this->db->select_sum('amount')->from('node_usages')
            ->join('nodes', 'node_usages.nodeid = nodes.id')->join('users', 'nodes.userid = users.id')
            ->where('users.id', $userid)->where('date', $date)->where('time', $hour)
            ->get()->row_array()['amount'];
    }

    public function getProduction($userid, $date, $hour)
    {
        return $this->db->from('solar_productions')
            ->join('solars', 'solar_productions.solarid = solars.id')->join('users', 'solars.userid = users.id')
            ->where('users.id', $userid)->where('date', $date)->where('time', $hour)
            ->get()->row_array();
    }

    public function getProductionTotalByDate($userid, $date)
    {
        return $this->db->select_sum('amount')->from('solar_productions')
            ->join('solars', 'solar_productions.solarid = solars.id')->join('users', 'solars.userid = users.id')
            ->where('users.id', $userid)->where('date', $date)
            ->get()->row_array()['amount'];
    }

    public function getProductionTotalByHour($userid, $date, $hour)
    {
        return $this->db->select('amount')->from('solar_productions')
            ->join('solars', 'solar_productions.solarid = solars.id')->join('users', 'solars.userid = users.id')
            ->where('users.id', $userid)->where('date', $date)->where('time', $hour)
            ->get()->row_array()['amount'];
    }

    public function getPrice($userid)
    {
        return $this->db->from('provider_price')->join('users', 'provider_price.providerid = users.providerid')
            ->where('users.id', $userid)->get()->row_array();
    }

    public function getVehicleAct($userid, $date, $hour)
    {
        return $this->db->from('vehicle_acts')
            ->join('vehicles', 'vehicle_acts.vehicleid = vehicles.id')->join('users', 'vehicles.userid = users.id')
            ->where('users.id', $userid)->where('date', $date)->where('time', $hour)
            ->get()->row_array();
    }

    public function getNode($id)
    {
        return $this->db->get_where('nodes', array('id'=>$id))->row_array();
    }

    public function getNodes($userid)
    {
        return $this->db->get_where('nodes', array('userid'=>$userid))->result_array();
    }

    public function insertNode($node)
    {
        return $this->db->insert('nodes', $node);
    }

    public function updateNode($node)
    {
        return $this->db->where('id', $node['id'])->update('nodes', $node);
    }

    public function updateNodes($nodes)
    {
        return $this->db->update_batch('nodes', $nodes, 'id');
    }

    public function getVehicle($id)
    {
        return $this->db->get_where('vehicles', array('userid'=>$id))->row_array();
    }

    public function updateVehicle($vehicle)
    {
        return $this->db->where('id', $vehicle['id'])->update('vehicles', $vehicle);
    }
}