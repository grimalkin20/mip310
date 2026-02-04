<?php	include "control-dashboard/connect.php"; ?>





=================================================================================================================================================================



**SLIDERS** 





<?php



                                       $query = "SELECT id, image, name FROM sliders ORDER BY id";

                                       $result = mysqli\_query($conn, $query);



                                       if ($result \&\& mysqli\_num\_rows($result) > 0) {

                                           while ($row = mysqli\_fetch\_assoc($result)) {

                                               $id = (int) $row\['id'];

?>



               <li> <img src="control-dashboard/uploads/materials/sliders/<?php echo $row\['image']; ?>" alt="<?php echo $row\['name']; ?>"> </li>



               

            <?php

											}

										} else {

											echo '<p>No images found in the sliders.</p>';

										}

										

										?>	              





=================================================================================================================================================================





**ANNOUNCEMETS AND NEWS** 





<?php

                                       // Load download categories and output as menu items.

                                       // Using MySQLi prepared statements for security and compatibility.

                                       // Cast IDs to int and escape names for safety and readability.



                                       $query = "SELECT id, content FROM announcements WHERE id IN (1, 2, 3)";

                                       $result = mysqli\_query($conn, $query);



                                       if ($result \&\& mysqli\_num\_rows($result) > 0) {

                                           while ($row = mysqli\_fetch\_assoc($result)) {

                                               $id = (int) $row\['id'];

                                               $content = htmlspecialchars($row\['content'], ENT\_QUOTES, 'UTF-8');

                                               echo "<li>{$content}</li>\\n";

                                           }

                                       } else {

                                           // Optional: show a placeholder when no categories exist or on error

                                           // echo '<li><a href="#">No downloads available</a></li>';

										}// For debugging you can uncomment the next line:

                                           // if (!$result) { echo '<!-- DB error: '.mysqli\_error($conn).' -->'; 

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



						

					<?php

                                       // Load download categories and output as menu items.

                                       // Using MySQLi prepared statements for security and compatibility.

                                       // Cast IDs to int and escape names for safety and readability.



                                       $query = "SELECT id, image FROM gallery\_images ORDER BY id DESC";

                                       $result = mysqli\_query($conn, $query);



                                       if ($result \&\& mysqli\_num\_rows($result) > 0) {

                                           while ($row = mysqli\_fetch\_assoc($result)) {

                                               $id = (int) $row\['id'];



                                           

                                           // Optional: show a placeholder when no categories exist or on error

                                           // echo '<li><a href="#">No downloads available</a></li>';

                                           // For debugging you can uncomment the next line:

                                           // if (!$result) { echo '<!-- DB error: '.mysqli\_error($conn).' -->'; 

?>

						



						<div class="isotope-item bottommargin\_30 col-lg-4 col-md-6 col-sm-12 college">



							<div class="vertical-item gallery-item content-absolute bottom-content text-center ds">



								<div class="item-media fill"> <img class="img-thumbnail" src="control-dashboard/uploads/materials/gallery/<?php echo $row\['image']; ?>">



									<div class="media-links middle-links type2">



										<div class="links-wrap"> <a class="p-view prettyPhoto" data-gal="prettyPhoto\[gal]"



											 href="control-dashboard/uploads/materials/gallery/<?php echo $row\['image']; ?>"></a> </div>



										</div>



									</div>



										<div class="item-content">



											<h4 class="item-meta text-uppercase bottommargin\_0"> <a href="#">DPS School, Barahiya,</a></h4>



										</div>



								</div>



							</div>		

						<?php

											}

										} else {

											echo '<p>No images found in the gallery.</p>';

										}

										

										?>	



					



						</div>











=================================================================================================================================================================





**HOMEWORKS AND DOENLOADS**





<?php





// Fetch data

$sql = "SELECT m.\*, mt.name as type\_name, c.name as class\_name, s.name as section\_name, sub.name as subject\_name 

       FROM materials m 

       LEFT JOIN material\_types mt ON m.type\_id = mt.id 

       LEFT JOIN classes c ON m.class\_id = c.id 

       LEFT JOIN sections s ON m.section\_id = s.id 

       LEFT JOIN subjects sub ON m.subject\_id = sub.id 

       ORDER BY m.created\_at DESC";

$result = $conn->query($sql);

$materials = $result->fetch\_all(MYSQLI\_ASSOC);



?>





<table class="materials-table">

   <thead>

       <tr>

           <th>S. No.</th>

           <th>Name</th>

           <th>Type</th>

           <th>Class</th>

           <th>Subject</th>

           <th>Created At</th>

           <th>File</th>

       </tr>

   </thead>

   <tbody>

       <?php foreach ($materials as $index => $material): ?>

           <tr>

               <td><?php echo $index + 1; ?></td>



               <td>

                   <strong><?php echo htmlspecialchars($material\['name']); ?></strong>

                   <?php if ($material\['description']): ?>

                       <br><small class="description"><?php echo htmlspecialchars($material\['description']); ?></small>

                   <?php endif; ?>

               </td>



               <td><span class="badge badge-info"><?php echo htmlspecialchars($material\['type\_name']); ?></span></td>



               <td><span class="badge badge-secondary"><?php echo htmlspecialchars($material\['class\_name']); ?></span></td>



               <td><span class="badge badge-primary"><?php echo htmlspecialchars($material\['subject\_name']); ?></span></td>



               <td><small class="timestamp"><?php echo htmlspecialchars($material\['created\_at']); ?></small></td>



               <td>

                   <a href="control-dashboard/materials/materials/<?php echo htmlspecialchars($material\['file']); ?>" 

                      target="\_blank" class="view-btn">

                       View

                   </a>

               </td>

           </tr>

       <?php endforeach; ?>







=================================================================================================================================================================















=================================================================================================================================================================













