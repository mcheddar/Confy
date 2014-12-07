<?php
/*************************************************************************************************/
/* The class handles HTML template files. Instance of this class gets strings to output in HTML, */
/* its functions can parse the template file into the correct form with all the strings and/or   */
/* conditions given.                                                                             */
/*************************************************************************************************/

class Template
{

  private $source;
  private $str_tags = array();
  private $loop_tags = array();
  private $if_tags = array();
  

  /* Loads source code of the template to the variable as a string */
  public function Template($tpl) {
  
    /* If template file exists, load its source code */
    if (file_exists($tpl)) {
 
      $this->source = file_get_contents($tpl);
    
    /* If template file does not exist, send an error message */
    } else {
 
      die("Template file $tpl not found.");
 
    }
  }
  
  
  /* Assigns tags and their replacements to the main array of tags to replace */ 
  public function assignStr($str_array, $value = false) {
    
    /* If input is an array of tags and replacements, add all of them to the main array */
    if (is_Array($str_array)) {
      
      if (sizeof($str_array) != 0) {
        
        foreach($str_array as $alias => $value) {
          
          $this->str_tags[$alias] = $value;
        }
      }
        
    /* If input is a single tag to replace, add it to the main array */    
    } else {
    
      /* In this case, $str_array is ALIAS and $valule was given on the input */
      $this->str_tags[$str_array] = $value;
    
    }
  }
  
  
  
  /* Parses the whole template. Each tag is replaced with a replacement defined in the $str_tags array */
  public function parseStr() {
  
    /* Do we have any tags assigned? */
    if (sizeof($this->str_tags) > 0) {
    
      /* Lets replace each tag with his replacement */
      foreach ($this->str_tags as $tag => $replacement) {
      
        $this->source = preg_replace("/{STR " . $tag . "}/", $replacement, $this->source);
      
      }
    } 
    
    /* Erase the array */
    unset($this->str_tags);  
  }  
  
  
  
  /* Assigns tags and their replacements to the main array, if the tag is already assigned, 
     creates an array within an array and saves another replacement for the next iteration of the loop */ 
  public function assignLoop($loop_array, $value = false) {
    
    /* If input is an array of tags and replacements, add all of them to the main array */
    if (is_Array($loop_array)) {
      
      if (sizeof($loop_array) != 0) {
        
        foreach($loop_array as $alias => $value) {
          
          /* If $alias has not been already assigned, creates a new array, if it was, adds the value to the end of the array, counting from 0 */
          $this->loop_tags[$alias][] = $value;
        }
      }
        
    /* If input is a single tag to replace, add it to the main array */    
    } else {
    
      /* In this case, $loop_array is ALIAS and $valule was given on the input */
      $this->loop_tags[$loop_array][] = $value;
    
    }
  }



  /* Finds block with the given name in the source code, removes start and end tags of the block
     and returns the content of the block */
  private function extractBlock($name, $type) {
  
    /* Define form of the start and end tag */
    $start_tag = '{'. $type .' ' . $name . '}';
    $end_tag = '{END ' . $name . '}';
       
    /* Find positions of the start and end tag */
    $start_tag_pos = strpos($this->source, $start_tag);
    $end_tag_pos = strpos($this->source, $end_tag);
    
    /* If there is no such a block, or one of the tags is missing, return a nice error message */
    if ($start_tag_pos === false || $end_tag_pos === false) {
    
      die ("Error: block {" . $name . "} not found.");
      
    } else {
    
      /* Find the start of the block, excluding start tag */
      $block_start = $start_tag_pos + strlen($start_tag);
      
      /* End of the block is on the position where end tag starts */
      $block_end = $end_tag_pos;
      
      /* Extract the content of the block*/
      $block = substr($this->source, $block_start, $block_end - $block_start);
      
      /* Remove the whole start tag */
      $this->source = deleteFromString($this->source, $start_tag_pos, strlen($start_tag));
      
      /* Remove the whole end tag, but first find the position of the end tag again, because start tag is already missing */
      $end_tag_pos = strpos($this->source, $end_tag);
      $this->source = deleteFromString($this->source, $end_tag_pos, strlen($end_tag));
      
      /* Return the content of the block and the starting position of the block */
      $arr['content'] = $block;
      $arr['start'] = $start_tag_pos;
      return $arr;
      
    }
  }

  
  /* Parses the loop of the given name */
  public function parseLoop($name) {
  
    /* First, extract the given block */
    $block = $this->extractBlock($name, 'LOOP');
    
    /* Do we have any assigned tags? */
    if (sizeof($this->loop_tags) > 0) {
      
      /* Determine the number of iterations required for this loop */
      $num = sizeof(reset($this->loop_tags));
      
      /* Okay, lets do the loop */
      for ($i = $num-1; $i >= 0; $i--) {
      
        /* In each iteration, look for all assigned tags and replace them with assigned replacements */
        foreach ($this->loop_tags as $tag => $array_of_replacements) {
        
          $this->source = preg_replace("/{" . $tag . "}/", $array_of_replacements[$i], $this->source);
          
        }
        
        /* If this is not the last iteration, insert the whole block in the source code again, 
           so we still have something to replace in the next iteration */
        if ($i > 0) { 
          $this->source = insertToString($this->source, $block['content'], $block['start']);
        }
        
      } 
    }
    
    /* Erase the array */
    unset($this->loop_tags);    
  }
  
  
  
  /* Assigns if-tags and their values to the main array of if tags to process */ 
  public function assignIf($if_array, $value = false) {
    
    /* If input is an array of if-tags and their values, add all of them to the main array */
    if (is_Array($if_array)) {
      
      if (sizeof($if_array) != 0) {
        
        foreach($if_array as $alias => $value) {
          
          $this->if_tags[$alias] = $value;
        }
      }
        
    /* If input is a single if-tag to process, add it to the main array */    
    } else {
    
      /* In this case, $if_array is ALIAS and $valule was given on the input */
      $this->if_tags[$if_array] = $value; 
    
    }
  }
  
  
  /* Parses if-tags in the whole template */
  public function parseIf() {
    
    /* Do we have any assigned if-tags? */
    if (sizeof($this->if_tags) > 0) {
      
      /* Lets go through all assigned if-tags and get their names and values */
      foreach ($this->if_tags as $tag => $value) {
        
        /* Extract this block */
        $block = $this->extractBlock($tag, 'IF');
        
        /* If the value of current if-tag is false, delete the whole block from the source code */   
        if ($value == false) {     

          $this->source = deleteFromString($this->source, $block['start'], strlen($block['content']));
        
        }   
      }
    }
    
    /* Erase the array */
    unset($this->if_tags);    
  }


  /* Outputs the final source code */
  public function output() {

    echo $this->source;
    
  }
  
}
?>