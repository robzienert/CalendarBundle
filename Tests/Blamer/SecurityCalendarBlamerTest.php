<?php
namespace Rizza\CalendarBundle\Tests\Blamer;

use Rizza\CalendarBundle\Blamer\SecurityCalendarBlamer;
use Rizza\CalendarBundle\Tests\CalendarTestCase;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * @author  Yannick Voyer <yan.voyer@gmail.com>
 * @package CalendarBundle
 */
class SecurityCalendarBlamerTest extends CalendarTestCase
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
        $owner           = $this->getMockUser();
        $calendar        = $this->getMockCalendar();
        $token           = null;

        if (null === $returnToken) {
            $this->setExpectedException("\RuntimeException");
        } else {
            $token = $this->getMockToken();
            if (false === $isGranted) {
                $calendar->expects($this->never())->method("setOwner");
            } else {
                $token    = $this->getMockToken_ExpectsGetUser($owner);
                $calendar = $this->getMockCalendar_ExpectsSetOwner($owner, $calendar);
            }

            $securityContext = $this->getMockSecurityContext_ExpectsIsGranted($isGranted, $securityContext);
        }
        $securityContext = $this->getMockSecurityContext_ExpectsGetToken($token, $securityContext);

        $blamer = $this->getBlamer($securityContext);
        $blamer->blame($calendar);
    }

    /**
     * Return the blamer to test
     *
     * @param SecurityContextInterface $securityContext The security context
     *
     * @return \Rizza\CalendarBundle\Blamer\SecurityCalendarBlamer
     */
    protected function getBlamer(SecurityContextInterface $securityContext)
    {
        return new SecurityCalendarBlamer($securityContext);
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