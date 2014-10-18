cd tar/files
tar -cf files.tar *
cd ../templates
tar -cf templates.tar *
cd ..
mv files/files.tar ../
mv templates/templates.tar ../
cd ..
tar -cf Dateien.tar *
rm files.tar templates.tar
echo "Tar-Plugin (Dateien.tar) erstellt"
