<?php

/*
 * This file is part of the Behat.
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\MinkExtension\Context\MinkContext;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;

/**
 * Behat test suite context.
 *
 * @author Balint Harmath
 */
class FeatureContext extends MinkContext
{
    /**
     * @var string
     */
    private $phpBin;
    /**
     * @var Process
     */
    private $process;
    /**
     * @var string
     */
    private $workingDir;

    /**
     * Prepares the things for test
     *
     * @BeforeScenario
     */
    public function prepareForTestCases()
    {
	$kapcsolat=mysqli_connect("localhost","root","root","pseudo_doodle");
			if(!$kapcsolat)
				die("Nem lehet kapcsolodni a MySQL kiszolgalohoz: ".mysqli_connect_error());

			$nodates=5;
			$dates=array("2015-08-01","2015-08-08","2015-08-11","2015-08-18","2015-08-25");
			foreach ($dates as $date)
			{
				$parancs="INSERT INTO sz_idopont (szavazas_id, idopont_d) 
						VALUES (".$nodates.",".$datum.")";							
				if(!mysqli_query($kapcsolat,$parancs))	
					echo "Nem lehet query-t menedzselni az adatbázison: ".mysqli_error($kapcsolat);
				$nodates--;
			}

			/*The datas that come through php are to be uploaded into "szavazas" table*/
			$parancs="INSERT INTO szavazas (cim,hely,leiras,nev,letrehozo_emailcim) 
						VALUES ('TEST','TEST','TEST TEST TEST','TESZT ELEK','TESZT@TESZT.hu')";  
			if(!mysqli_query($kapcsolat,$parancs))
				echo "Nem lehet query-t menedzselni az adatbázison: ".mysqli_error($kapcsolat);

			

    }

    /**
     * Checks with the current options the current case would be working on the next page
     *
     * @Given /^ (?:on page beallitasok.php the )?YNM option is checked$/
     *
     */
    public function YNMOptionIsChecked()
    {
        $content = strtr((string) $content, array("'''" => '"""'));
        $this->createFile($this->workingDir . '/' . $filename, $content);
    }

    /**
     * Checks whether specified file exists and contains specified string.
     *
     * @Then it should appear on the szavazasok.php
     *
     * @param   string       $szavazasUrl
     */
    public function YNMAppearsOnSzavazasok($szavazasUrl)
    {


        PHPUnit_Framework_Assert::assertEquals($this->getExpectedOutput($text), $fileContent);
    }

    /**
     *
     * @Given that the one vote per person option is checked
     *
     */
    public function oneVotePerOptionIsChecked($path)
    {
        $this->moveToNewPath($path);
    }

    /**
     *
     * @Then it should appear on the szavazasok.php
     *
     * @param   string       $szavazasUrl
     */
    public function oneVotePerOptionAppearsOnSzavazasok($szavazasUrl)
    {


        PHPUnit_Framework_Assert::assertEquals($this->getExpectedOutput($text), $fileContent);
    }

    /**
     *
     * @Given that the one vote per date option is checked
     *
     * @param   string $path
     */
    public function oneVotePerDateIsChecked($path)
    {
        PHPUnit_Framework_Assert::assertFileExists($this->workingDir . DIRECTORY_SEPARATOR . $path);
    }

    /**
     *
     * @Then it should appear on the szavazasok.php
     *
     * @param   string       $szavazasUrl
     */
    public function oneVotePerDateAppearsOnSzavazasok($szavazasUrl)
    {


        PHPUnit_Framework_Assert::assertEquals($this->getExpectedOutput($text), $fileContent);
    }

    /**
     *
     * @Given that the valid email option is checked
     *
     * @param   string $path
     */
    public function validEmailOptionIsChecked($path)
    {
        PHPUnit_Framework_Assert::assertFileExists($this->workingDir . DIRECTORY_SEPARATOR . $path);
    }

    /**
     *
     * @Then it should appear on the szavazasok.php
     *
     * @param   string       $szavazasUrl
     */
    public function validEmailOptionAppearsOnSzavazasok($szavazasUrl)
    {


        PHPUnit_Framework_Assert::assertEquals($this->getExpectedOutput($text), $fileContent);
    }
    private function getExpectedOutput(PyStringNode $expectedText)
    {
        $text = strtr($expectedText, array('\'\'\'' => '"""', '%%TMP_DIR%%' => sys_get_temp_dir() . DIRECTORY_SEPARATOR));

        // windows path fix
        if ('/' !== DIRECTORY_SEPARATOR) {
            $text = preg_replace_callback(
                '/ features\/[^\n ]+/', function ($matches) {
                    return str_replace('/', DIRECTORY_SEPARATOR, $matches[0]);
                }, $text
            );
            $text = preg_replace_callback(
                '/\<span class\="path"\>features\/[^\<]+/', function ($matches) {
                    return str_replace('/', DIRECTORY_SEPARATOR, $matches[0]);
                }, $text
            );
            $text = preg_replace_callback(
                '/\+[fd] [^ ]+/', function ($matches) {
                    return str_replace('/', DIRECTORY_SEPARATOR, $matches[0]);
                }, $text
            );
        }

        return $text;
    }

    /**
     * Checks whether previously ran command failed|passed.
     *
     * @Then /^it should (fail|pass)$/
     *
     * @param   string $success "fail" or "pass"
     */
    public function itShouldFail($success)
    {
        if ('fail' === $success) {
            if (0 === $this->getExitCode()) {
                echo 'Actual output:' . PHP_EOL . PHP_EOL . $this->getOutput();
            }

            PHPUnit_Framework_Assert::assertNotEquals(0, $this->getExitCode());
        } else {
            if (0 !== $this->getExitCode()) {
                echo 'Actual output:' . PHP_EOL . PHP_EOL . $this->getOutput();
            }

            PHPUnit_Framework_Assert::assertEquals(0, $this->getExitCode());
        }
    }

    private function getExitCode()
    {
        return $this->process->getExitCode();
    }

    private function getOutput()
    {
        $output = $this->process->getErrorOutput() . $this->process->getOutput();

        // Normalize the line endings in the output
        if ("\n" !== PHP_EOL) {
            $output = str_replace(PHP_EOL, "\n", $output);
        }

        // Replace wrong warning message of HHVM
        $output = str_replace('Notice: Undefined index: ', 'Notice: Undefined offset: ', $output);

        return trim(preg_replace("/ +$/m", '', $output));
    }

    private function createFile($filename, $content)
    {
        $path = dirname($filename);
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        file_put_contents($filename, $content);
    }

    private function moveToNewPath($path)
    {
        $newWorkingDir = $this->workingDir .'/' . $path;
        if (!file_exists($newWorkingDir)) {
            mkdir($newWorkingDir, 0777, true);
        }

        $this->workingDir = $newWorkingDir;
    }

    private static function clearDirectory($path)
    {
        $files = scandir($path);
        array_shift($files);
        array_shift($files);

        foreach ($files as $file) {
            $file = $path . DIRECTORY_SEPARATOR . $file;
            if (is_dir($file)) {
                self::clearDirectory($file);
            } else {
                unlink($file);
            }
        }

        rmdir($path);
    }
}
