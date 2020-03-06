<?php
/**
 *
 * @author Johan Steyn <jsteyn@quint.co.uk>
 * @link https://unfuddle.com/stack/docs/api
 * Date: 2020/03/06
 * Time: 12:50
 */
namespace Inqbate\Unfuddle\Project;


use Inqbate\Unfuddle\AttachementTrait;
use Inqbate\Unfuddle\CommentTrait;
use Inqbate\Unfuddle\UnfuddleAbstract;

class Ticket extends UnfuddleAbstract
{
    use AttachementTrait, CommentTrait;

}
