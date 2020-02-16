program Project1;

uses
  System.StartUpCopy,
  FMX.Forms,
  Unit1 in 'Unit1.pas' {Form1};

type
  Class1 = class
  end;

  /// <metaclass>AssociationClass</metaclass>
  AssociationClass1 = class
  end;

  Enum1 = (eField1);
{$R *.res}

begin
  Application.Initialize;
  Application.CreateForm(TForm1, Form1);
  Application.Run;

end.
