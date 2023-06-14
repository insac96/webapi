<?php
class MissionPDO {
  static $PDO_GetAllMission = "SELECT * FROM ny_mission";
  static $PDO_GetMission = "SELECT * FROM ny_mission WHERE id=:id";
  static $PDO_DeleteMission = "DELETE FROM ny_mission WHERE id=:id";

  static $PDO_GetAllMissionCustom = "SELECT * FROM ny_mission_custom";
  static $PDO_GetMissionCustom = "SELECT * FROM ny_mission_custom WHERE id=:id";
  static $PDO_DeleteMissionCustom = "DELETE FROM ny_mission_custom WHERE id=:id";
}