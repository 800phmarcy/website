
<?php $this->load->view('components/header', $data)?>
   
<?php echo $data['page_content']; ?> 
    
<?php if($data['showFooter']){$this->load->view('components/footer'); }?>


 