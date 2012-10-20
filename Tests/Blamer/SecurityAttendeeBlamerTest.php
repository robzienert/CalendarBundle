<?php
/**
 * @author  Yannick Voyer <yan.voyer@gmail.com>
 * @package CalendarBundle
 */

namespace Rizza\CalendarBundle\Tests\Blamer;

use Rizza\CalendarBundle\Blamer\SecurityAttendeeBlamer;
use Rizza\CalendarBundle\Tests\CalendarTestCase;
use Symfony\Component\Security\Core\SecurityContextInterface;

class SecurityAttendeeBlamerTest extends CalendarTestCase
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
        $user            = $this->getMockUser();
        $attendee        = $this->getMockAttendee();
        $token           = null;

        if (null === $returnToken) {
            $this->setExpectedException("\RuntimeException");
        } else {
            $token = $this->getMockToken();
            if (false === $isGranted) {
                $attendee->expects($this->never())->method("setUser");
            } else {
                $token    = $this->getMockToken_ExpectsGetUser($user);
                $attendee = $this->getMockAttendee_ExpectsSetUser($user, $attendee);
            }

            $securityContext = $this->getMockSecurityContext_ExpectsIsGranted($isGranted, $securityContext);
        }
        $securityContext = $this->getMockSecurityContext_ExpectsGetToken($token, $securityContext);

        $blamer = $this->getBlamer($securityContext);
        $blamer->blame($attendee);
    }

    /**
     * Return the blamer to test
     *
     * @param unknown_type $securityContext
     * @return \Rizza\CalendarBundle\Blamer\SecurityAttendeeBlamer
     */
    protected function getBlamer(SecurityContextInterface $securityContext)
    {
        return new SecurityAttendeeBlamer($securityContext);
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