<?php

$conn = mysqli_connect("localhost", "root", "", "ros");


if ($conn) {
  echo "connected";
} else {
  echo "Failed";
}
