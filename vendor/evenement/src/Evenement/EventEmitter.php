<?php declare(strict_types=1);

/*
 * This file is part of Evenement.
 *
 * (c) Igor Wiedler <igor@wiedler.ch>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Evenement;

require_once "vendor/evenement/src/Evenement/EventEmitterInterface.php";
require_once "vendor/evenement/src/Evenement/EventEmitterTrait.php";

class EventEmitter implements EventEmitterInterface
{
    use EventEmitterTrait;
}
