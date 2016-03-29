<?php
/**
 * ClearIce CLI Argument Parser
 * Copyright (c) 2012-2014 James Ekow Abaka Ainooson
 * 
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 * 
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE. 
 * 
 * @author James Ainooson <jainooson@gmail.com>
 * @copyright Copyright 2012-2014 James Ekow Abaka Ainooson
 * @license MIT
 */

namespace clearice;

/**
 * Class responsible for generating the help messages. 
 * This class reads all the options passed on to the ClearIce library and generates 
 * help messages. The help messages could either be displayed automatically when 
 * the passes the --help option (on an app with the automatic help feature enabled) 
 * is passed or when the app explicitly calls the ClearIce::getHelpMessage() method.
 * 
 * @internal
 */
class HelpMessage
{
    /**
     * The message which is usually generated by the constructor.
     * @var string
     */
    private $message = '';
    
    /**
     * The constructor for the HelpMessage class. This constructor does the work
     * of generating the help message. This means that nothing can be done to
     * change the help message after the class has been instantiated.
     * 
     * @param array $params An associative array which contains the details needed
     *                      to help generate the help message.s
     */
    public function __construct($params)
    {
        $sections = [];
        
        // Build up sections and use them as the basis for the help message
        $this->getDescriptionMessage($params, $sections, 'description');
        $this->getUsageMessage($params, $sections);
        $this->getOptionsMessage($params, $sections);
        $this->getDescriptionMessage($params, $sections, 'footnote');
        
        // Glue up all sections with newline characters to build the help
        // message
        foreach($sections as $i => $section)
        {
            $sections[$i] = implode("\n", $section);
        }
        
        $this->message = implode("\n", $sections);        
    }
    
    /**
     * The method runs through all the commands and generates formatted lines
     * of text to be used as the help message for each commands.
     * 
     * @param array $commands An array of associative arrays with infomation 
     *                        about all commands configured into ClearIce.
     * @return array
     */
    private function getCommandsHelp($commands)
    {
        $commandsHelp = array('Commands:');
        foreach ($commands as $command)
        {
            $commandsHelp[] = implode("\n", $this->formatCommandHelp($command));
        }
        $commandsHelp[] = '';    
        return $commandsHelp;
    }
    
    /**
     * The method runs through all the commands and generates formatted lines
     * of text to be used as the help message each option.
     * 
     * @param array $options    An array of associative arrays with infomation 
     *                          about all options configured into ClearIce.
     * @param string $command   All options returned would belong to the command 
     *                          stated in this argument.
     * @param string $title     A descriptive title for the header of this set 
     *                          of options.
     * @return array
     */    
    private function getOptionsHelp($options, $groups, $command = '', $title = 'Options:')
    {
        
        $prevGroup = null;
        $optionHelp = array($title);
        foreach ($options as $option)
        {
            if($option['command'] != $command) {
                continue;
            }
            if($prevGroup != $option['group']) {
                $optionHelp[] = '';
                $optionHelp[] = "{$groups[$option['group']]['help']}:";
                $prevGroup = $option['group'];
            }
            $optionHelp[] = implode("\n", $this->formatOptionHelp($option));
        }      
        $optionHelp[] = '';
        return $optionHelp;
    }
    
    /**
     * Formats the help line of a value which is accepted by an option. If a 
     * value type is provided in the option, it is used if not it uses a generic 
     * "VALUE" to show that an option can accept a value.
     * 
     * @param array $option
     * @return string
     */
    private function formatValue($option)
    {
        if($option['has_value'])
        {
            return "=" . (isset($option['value']) ? $option['value'] : "VALUE");
        }
    }
    
    /**
     * Formats the argument parts of the help line. If an option has both a long
     * and a short form both forms are put together, if it has either a short or
     * a long form, the respective form is formatted. The formatting includes
     * placing a comma between the two forms and padding the output with the
     * appropriate spaces.
     * 
     * @param array $option
     * @return string
     */
    private function formatArgument($option)
    {
        $valueHelp = $this->formatValue($option);
        if(isset($option['long']) && isset($option['short']))            
        {
            $argumentHelp = sprintf(
                "  %s, %-22s ", "-{$option['short']}", "--{$option['long']}$valueHelp"
            );
        }
        else if(isset($option['long']))
        {
            $argumentHelp = sprintf(
                "  %-27s", "--{$option['long']}$valueHelp"
            );
        }
        else if(isset($option['short']))
        {
            $argumentHelp = sprintf(
                "  %-27s", "-{$option['short']}"
            );                
        }      
        return $argumentHelp;
    }
    
    /**
     * Wraps the help message arround the argument by producing two different
     * columns. The argument is placed in the first column and the help message
     * is placed in the second column.
     * 
     * @param string $argumentPart
     * @param string $help
     * @param integer $minSize
     * @return array
     */
    private function wrapHelp($argumentPart, &$help, $minSize = 29)
    {
        if(strlen($argumentPart) <= $minSize)
        {
            return $argumentPart . array_shift($help);
        }
        else
        {
            return $argumentPart;
        }        
    }
    
    /**
     * Format the help message for an option. This would involve generating a 
     * sring with your option and and wrapping the help message around it.
     * 
     * @param type $option
     * @return string
     */
    private function formatOptionHelp($option)
    {
        $optionHelp = array();
        $help = explode("\n", wordwrap($option['help'], 50));
        $argumentPart = $this->formatArgument($option);

        $optionHelp[] = $this->wrapHelp($argumentPart, $help);

        foreach($help as $helpLine)
        {  
            $optionHelp[] = str_repeat(' ', 29) . "$helpLine" ;
        }        
        return $optionHelp;
    }  
    
    /**
     * Format the help message for a command. This would involve wrapping the
     * help message for a given command around the command.
     * 
     * @param type $command
     * @return string
     */
    private function formatCommandHelp($command)
    {
        $commandHelp = array();
        $help = explode("\n", wordwrap($command['help'], 59));
        $commandHelp[] = $this->wrapHelp(sprintf("% -20s", $command['command']), $help, 20);
        foreach($help as $helpLine)
        {
            $commandHelp[] = str_repeat(' ', 20) . $helpLine;
        }
        return $commandHelp;
    }
    
    private function getDescriptionMessage(array $params, array &$sections, $section)
    {
        if(isset($params[$section])) {
            $sections[$section] = [wordwrap($params[$section]), ''];
        }
    }
    
    private function getOptionsMessage(array $params, array &$sections)
    {
        $options = $params['options']->getArray();
        if(count($params['groups'])) {
            $groups = [];
            foreach($options as $option) {
                $groups[] = $option['group'];
            }
            array_multisort($groups, SORT_ASC, $options);
        }        
        $optionHelp = $this->getOptionsHelp($options, $params['groups']);
        if(count($params['commands']) > 0 && $params['command'] == '') 
        {
            $sections['commands'] = $this->getCommandsHelp($params['commands']); 
        }
        else if($params['command'] != '')
        {
            $sections['command_options'] = $this->getOptionsHelp(
                $options, 
                $params['groups'],
                $params['command'], 
                "Options for {$params['command']} command:"
            );
        }
        
        $sections['options'] = $optionHelp;        
    }


    /**
     * Returns the usage message for either the command or the main script
     * depending on the state in which the HelpMessage class currently is.
     * 
     * @global array $argv The arguments passed to the 
     * @param array $params A copy of the parameters passed to the HelpMessage class
     */
    private function getUsageMessage(array $params, array &$sections)
    {
        global $argv;
        $usageMessage = [];
        $usageSet = false;
        
        if($params['command'] != '')
        {
            if(isset($params['commands'][$params['command']]['usage']))
            {
                $usage = $params['commands'][$params['command']]['usage'];
            }
            else
            {
                $usage = "{$params['command']} [options]..";
            }
        }
        else
        {
            $usage = $params['usage'];
        }
        
        if(is_string($usage))
        {
            $usageMessage[] = "Usage:\n  {$argv[0]} " . $usage;
            $usageSet = true;
        }
        elseif (is_array($usage)) 
        {
            $usageMessage[] = "Usage:";
            foreach($usage as $usage)
            {
                $usageMessage[] = "  {$argv[0]} {$usage}";
            }
            $usageSet = true;
        }
        if($usageSet){
            $usageMessage[] = "";
            $sections['usage'] = $usageMessage;
        }
    }    
    
    /**
     * Returns the message as a string.
     * @return string
     */
    public function __toString()
    {
        return $this->message;
    }
}

