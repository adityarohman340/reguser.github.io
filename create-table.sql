create table [dbo].[Registration](
    id INT NOT NULL IDENTITY(1,1) PRIMARY KEY(id),
    Nama VARCHAR(30),
    Email VARCHAR(30),
    Profesi VARCHAR(30),
    Umur INT NOT NULL,
    date DATE
);