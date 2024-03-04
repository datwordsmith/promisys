
    <form action="functions/fetchmyprofile.php" method="POST" enctype="multipart/form-data">
        <div class="text-center" style="margin-bottom: 15px;">
            <b>Upload Documents</b>
        </div>

        <div class="form-group col-md-12 col-xs-12">
            <input type="text" class="form-control" placeholder="File Title" name = "filetitle" value="" required>
        </div>

        <div class="form-group col-md-12 col-xs-12">
            <input type="file" class="form-control pull-right" placeholder="" name="file"  id="my_file" required>
            <!--<div style="clear: both;"></div>-->	
        </div>

        <div class="form-group col-md-12 col-xs-12">
            <span>&nbsp;</span>
            <button type="submit" name= "addpic" id="doc_upload" class="btn btn-default btn-block btn-flat"><i class="ace-icon fa fa-floppy-o"></i> Save File</button>
        </div>
    </form>																	

