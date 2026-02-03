<?php	include "control-dashboard/connect.php"; ?>





=================================================================================================================================================================



**SLIDERS** 





<?php



&nbsp;                                       $query = "SELECT id, image, name FROM sliders ORDER BY id";

&nbsp;                                       $result = mysqli\_query($conn, $query);



&nbsp;                                       if ($result \&\& mysqli\_num\_rows($result) > 0) {

&nbsp;                                           while ($row = mysqli\_fetch\_assoc($result)) {

&nbsp;                                               $id = (int) $row\['id'];

?>



&nbsp;               <li> <img src="control-dashboard/uploads/materials/sliders/<?php echo $row\['image']; ?>" alt="<?php echo $row\['name']; ?>"> </li>



&nbsp;               

&nbsp;            <?php

&nbsp;											}

&nbsp;										} else {

&nbsp;											echo '<p>No images found in the sliders.</p>';

&nbsp;										}

&nbsp;										

&nbsp;										?>	              





=================================================================================================================================================================





**ANNOUNCEMETS AND NEWS** 



&nbsp;

<?php

&nbsp;                                       // Load download categories and output as menu items.

&nbsp;                                       // Using MySQLi prepared statements for security and compatibility.

&nbsp;                                       // Cast IDs to int and escape names for safety and readability.



&nbsp;                                       $query = "SELECT id, content FROM announcements WHERE id IN (1, 2, 3)";

&nbsp;                                       $result = mysqli\_query($conn, $query);



&nbsp;                                       if ($result \&\& mysqli\_num\_rows($result) > 0) {

&nbsp;                                           while ($row = mysqli\_fetch\_assoc($result)) {

&nbsp;                                               $id = (int) $row\['id'];

&nbsp;                                               $content = htmlspecialchars($row\['content'], ENT\_QUOTES, 'UTF-8');

&nbsp;                                               echo "<li>{$content}</li>\\n";

&nbsp;                                           }

&nbsp;                                       } else {

&nbsp;                                           // Optional: show a placeholder when no categories exist or on error

&nbsp;                                           // echo '<li><a href="#">No downloads available</a></li>';

&nbsp;										}// For debugging you can uncomment the next line:

&nbsp;                                           // if (!$result) { echo '<!-- DB error: '.mysqli\_error($conn).' -->'; 

?>









-------------------------------------





<div class="col-md-8">

                                    <ul class="list1 darklinks">

                                        <?php

                                        // Load announcements and output as list items

                                        // Using MySQLi prepared statements for security and compatibility

                                        $query = "SELECT id, content FROM announcements WHERE category\_id IN (1, 2, 3)";

                                        $result = mysqli\_query($conn, $query);



                                        if ($result \&\& mysqli\_num\_rows($result) > 0) {

                                            while ($row = mysqli\_fetch\_assoc($result)) {

                                                $id = (int) $row\['id'];

                                                $content = htmlspecialchars($row\['content'], ENT\_QUOTES, 'UTF-8');

                                                echo "<li>{$content}</li>\\n";

                                            }

                                        }

                                        ?>

                                    </ul>

                                </div>



                                <div class="col-md-4">

                                    <ul class="list1 darklinks">

                                        <?php

                                        // Load announcement types/categories

                                        $query = "SELECT a.id, a.content, n.name as category\_name

                                                  FROM announcements a

                                                  LEFT JOIN announcement\_categories n ON a.category\_id = n.id

                                                  WHERE a.id IN (1, 2, 3)

                                                  ORDER BY a.id DESC";

                                        $result = mysqli\_query($conn, $query);



                                        if ($result \&\& mysqli\_num\_rows($result) > 0) {

                                            while ($row = mysqli\_fetch\_assoc($result)) {

                                                $category = htmlspecialchars($row\['category\_name'] ?? 'Uncategorized', ENT\_QUOTES, 'UTF-8');

                                                echo "<li><strong>Type:</strong> {$category}</li>\\n";

                                            }

                                        }

                                        ?>

                                    </ul>

                                </div>









=================================================================================================================================================================





**GALLERY IMAGE** 









<div class="isotope\_container isotope row masonry-layout" data-filters=".isotope\_filters">



&nbsp;						

&nbsp;					<?php

&nbsp;                                       // Load download categories and output as menu items.

&nbsp;                                       // Using MySQLi prepared statements for security and compatibility.

&nbsp;                                       // Cast IDs to int and escape names for safety and readability.



&nbsp;                                       $query = "SELECT id, image FROM gallery\_images ORDER BY id DESC";

&nbsp;                                       $result = mysqli\_query($conn, $query);



&nbsp;                                       if ($result \&\& mysqli\_num\_rows($result) > 0) {

&nbsp;                                           while ($row = mysqli\_fetch\_assoc($result)) {

&nbsp;                                               $id = (int) $row\['id'];



&nbsp;                                           

&nbsp;                                           // Optional: show a placeholder when no categories exist or on error

&nbsp;                                           // echo '<li><a href="#">No downloads available</a></li>';

&nbsp;                                           // For debugging you can uncomment the next line:

&nbsp;                                           // if (!$result) { echo '<!-- DB error: '.mysqli\_error($conn).' -->'; 

?>

&nbsp;						



&nbsp;						<div class="isotope-item bottommargin\_30 col-lg-4 col-md-6 col-sm-12 college">



&nbsp;							<div class="vertical-item gallery-item content-absolute bottom-content text-center ds">



&nbsp;								<div class="item-media fill"> <img class="img-thumbnail" src="control-dashboard/uploads/materials/gallery/<?php echo $row\['image']; ?>">



&nbsp;									<div class="media-links middle-links type2">



&nbsp;										<div class="links-wrap"> <a class="p-view prettyPhoto" data-gal="prettyPhoto\[gal]"



&nbsp;											 href="control-dashboard/uploads/materials/gallery/<?php echo $row\['image']; ?>"></a> </div>



&nbsp;										</div>



&nbsp;									</div>



&nbsp;										<div class="item-content">



&nbsp;											<h4 class="item-meta text-uppercase bottommargin\_0"> <a href="#">DPS School, Barahiya,</a></h4>



&nbsp;										</div>



&nbsp;								</div>



&nbsp;							</div>		

&nbsp;						<?php

&nbsp;											}

&nbsp;										} else {

&nbsp;											echo '<p>No images found in the gallery.</p>';

&nbsp;										}

&nbsp;										

&nbsp;										?>	



&nbsp;					



&nbsp;						</div>











=================================================================================================================================================================





**HOMEWORKS AND DOENLOADS**





<?php





// Fetch data

$sql = "SELECT m.\*, mt.name as type\_name, c.name as class\_name, s.name as section\_name, sub.name as subject\_name 

&nbsp;       FROM materials m 

&nbsp;       LEFT JOIN material\_types mt ON m.type\_id = mt.id 

&nbsp;       LEFT JOIN classes c ON m.class\_id = c.id 

&nbsp;       LEFT JOIN sections s ON m.section\_id = s.id 

&nbsp;       LEFT JOIN subjects sub ON m.subject\_id = sub.id 

&nbsp;       ORDER BY m.created\_at DESC";

$result = $conn->query($sql);

$materials = $result->fetch\_all(MYSQLI\_ASSOC);



?>





<table class="materials-table">

&nbsp;   <thead>

&nbsp;       <tr>

&nbsp;           <th>S. No.</th>

&nbsp;           <th>Name</th>

&nbsp;           <th>Type</th>

&nbsp;           <th>Class</th>

&nbsp;           <th>Subject</th>

&nbsp;           <th>Created At</th>

&nbsp;           <th>File</th>

&nbsp;       </tr>

&nbsp;   </thead>

&nbsp;   <tbody>

&nbsp;       <?php foreach ($materials as $index => $material): ?>

&nbsp;           <tr>

&nbsp;               <td><?php echo $index + 1; ?></td>



&nbsp;               <td>

&nbsp;                   <strong><?php echo htmlspecialchars($material\['name']); ?></strong>

&nbsp;                   <?php if ($material\['description']): ?>

&nbsp;                       <br><small class="description"><?php echo htmlspecialchars($material\['description']); ?></small>

&nbsp;                   <?php endif; ?>

&nbsp;               </td>



&nbsp;               <td><span class="badge badge-info"><?php echo htmlspecialchars($material\['type\_name']); ?></span></td>



&nbsp;               <td><span class="badge badge-secondary"><?php echo htmlspecialchars($material\['class\_name']); ?></span></td>



&nbsp;               <td><span class="badge badge-primary"><?php echo htmlspecialchars($material\['subject\_name']); ?></span></td>



&nbsp;               <td><small class="timestamp"><?php echo htmlspecialchars($material\['created\_at']); ?></small></td>



&nbsp;               <td>

&nbsp;                   <a href="control-dashboard/materials/materials/<?php echo htmlspecialchars($material\['file']); ?>" 

&nbsp;                      target="\_blank" class="view-btn">

&nbsp;                       View

&nbsp;                   </a>

&nbsp;               </td>

&nbsp;           </tr>

&nbsp;       <?php endforeach; ?>







=================================================================================================================================================================















=================================================================================================================================================================













