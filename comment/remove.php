<?php
/* @File: comment/remove.php
 *
 *              --- API iSocialNetwork ---
 *
 * @Author: Fabien GAMELIN, Ismaïl NGUYEN, Bruno VACQUEREL
 *
 *               ESGI - 3A AL - 2014/2015
 */

include("../BusinessLayer.php");

class CommentRemove extends BusinessLayer
{
	public function __construct()
	{
		parent::__construct();
	}

	public function run()
	{
		try
		{
			if(getMethod() == "POST")
	    	{
				$_idComment = getRequest("idComment");
				$_User_idUser = getIdUser();				

        		$params = array(
								":idComment" => $_idComment,
								":user_idUser" => $_user_idUser								
								);

				$statement = $m_db->prepare("SELECT * FROM comment WHERE idComment = :idComment AND user_idUser = :user_idUser");
				if($statement->execute($params))
				{  
					$statement = $m_db->prepare("DELETE FROM comment WHERE idComment = :idComment AND user_idUser = :user_idUser");
					if(!($statement && $statement->execute(array($params))))
          			{
						$this->setCode(27); //Error removing comment
					}
				}
				else
				{
					$this->setCode(18); //Bad request, comment does not exist
				}
			}
			else
			{
				$this->setCode(23); //Request method not accepted
			}
		}
		catch(PDOException $e)
		{
			$this->setCode(36); //Server error
		}
		finally
		{
			$this->response();
		}
	}
}

$api = new CommentRemove();
$api->run();
?>
