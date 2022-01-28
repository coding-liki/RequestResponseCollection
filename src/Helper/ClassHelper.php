<?php

namespace CodingLiki\RequestResponseCollection\Helper;

class ClassHelper
{
    public static function getClassesFromDirectoryRecursive(string $classesDirectory): array
    {
        $directory = new \RecursiveDirectoryIterator($classesDirectory);
        $iterator  = new \RecursiveIteratorIterator($directory);
        $regex     = new \RegexIterator($iterator, '/^.+\.php$/i', \RegexIterator::GET_MATCH);

        $classes = [];

        foreach ($regex as $file) {
            $classes[] = self::getClassFromFile($file[0]);
        }

        return $classes;
    }

    public static function getClassFromFile(string $file): string
    {
        $fp = fopen($file, 'r');
        $class = $namespace = $buffer = '';
        $i = 0;
        while (!$class) {
            if (feof($fp)) break;

            $buffer .= fread($fp, 512);

            $tokens = token_get_all($buffer);
            if (!str_contains($buffer, '{')) continue;

            for (;$i<count($tokens);$i++) {
                if ($tokens[$i][0] === T_NAMESPACE ) {
                    for ($j=$i+1;$j<count($tokens); $j++) {
                        if ($tokens[$j][0] === T_STRING || $tokens[$j][0] === T_NAME_QUALIFIED) {
                            $namespace .= '\\'.$tokens[$j][1];
                        } else if ($tokens[$j] === '{' || $tokens[$j] === ';') {
                            break;
                        }
                    }
                }

                if ($tokens[$i][0] === T_CLASS) {
                    for ($j=$i+1;$j<count($tokens);$j++) {
                        if ($tokens[$j] === '{') {
                            if(is_array($tokens[$i+2])) {
                                $class = $tokens[$i + 2][1];
                            }
                        }
                    }
                }
            }
        }

        fclose($fp);

        return "$namespace\\$class";
    }
}