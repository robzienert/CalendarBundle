<?php
namespace Rizza\CalendarBundle\Tests\Blamer;

use Rizza\CalendarBundle\Blamer\SecurityEventBlamer;
use Rizza\CalendarBundle\Tests\CalendarTestCase;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * @author  Yannick Voyer <yan.voyer@gmail.com>
 * @package CalendarBundle
 */
class SecurityEventBlamerTest extends CalendarTestCase
{
    /**
     * @dataProvider getTestData
     *
     * @param boolean $returnToken Whether the token should be returned
     * @param boolean $isGranted   Whether the access is granted
     */
    public function testBlame($returnToken, $isGranted)
    {
        $securityContext = $this->getMockSecurityContext();
        $organizer       = $this->getMockUser();
        $event           = $this->getMockEvent();
        $token           = null;

        if (null === $returnToken) {
            $this->setExpectedException("\RuntimeException");
        } else {
            $token = $this->getMockToken();
            if (false === $isGranted) {
                $event->expects($this->never())->method("setOrganizer");
            } else {
                $token = $this->getMockToken_ExpectsGetUser($organizer);
                $event = $this->getMockEvent_ExpectsSetOrganizer($organizer, $event);
            }

            $securityContext = $this->getMockSecurityContext_ExpectsIsGranted($isGranted, $securityContext);
        }
        $securityContext = $this->getMockSecurityContext_ExpectsGetToken($token, $securityContext);

        $blamer = $this->getBlamer($securityContext);
        $blamer->blame($event);
    }

    /**
     * Return the blamer to test
     *
     * @param SecurityContextInterface $securityContext The security context
     *
     * @return \Rizza\CalendarBundle\Blamer\SecurityEventBlamer
     */
    protected function getBlamer(SecurityContextInterface $securityContext)
    {
        return new SecurityEventBlamer($securityContext);
    }

    public static function getTestData()
    {
        return array(
                array(null, false),
                array(true, false),
                array(true, true),
        );
    }
}